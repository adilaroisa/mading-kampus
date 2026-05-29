<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with('category', 'author');

        // Tambahkan kondisi jika ada parameter kategori di URL
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Jangan tampilkan artikel yang sudah kedaluwarsa
        $query->where(function($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });

        $articles = $query->orderByDesc('is_pinned')->latest()->paginate(9);
        
        // Mempertahankan parameter query saat pindah halaman paginasi
        $articles->appends($request->all());

        return view('welcome', compact('articles'));
    }


    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->with([
                'comments' => function($q) {
                    $q->whereNull('parent_id')->oldest();
                },
                'comments.user',
                'comments.replies.user',
                'category', 
                'author'
            ])
            ->firstOrFail();
        
        $sessionKey = 'viewed_article_' . $article->id;
        if (!session()->has($sessionKey)) {
            $article->increment('views_count');
            session()->put($sessionKey, true);
        }

        return view('articles.show', compact('article'));
    }

    public function bookmark(Article $article)
    {
        auth()->user()->bookmarks()->toggle($article->id);
        return back()->with('success', 'Status bookmark diperbarui!');
    }

    public function myBookmarks()
    {
        $bookmarks = auth()->user()->bookmarks()->with(['category', 'author'])->paginate(10);
        return view('bookmarks.index', compact('bookmarks'));
    }

    public function storeComment(Request $request, Article $article)
    {
        $request->validate(['body' => 'required|min:1']);

        $comment = Comment::create([
            'article_id' => $article->id,
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id,
            'body' => $request->body
        ]);

        $comment->load('user');

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'comment' => $comment,
                'message' => 'Komentar berhasil ditambahkan!'
            ]);
        }

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function updateComment(Request $request, Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) abort(403);

        $request->validate(['body' => 'required|min:1']);

        $comment->update([
            'body' => $request->body,
            'is_edited' => true
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Komentar berhasil diperbarui.'
            ]);
        }

        return back()->with('success', 'Komentar berhasil diperbarui.');
    }

    public function destroyComment(Request $request, Comment $comment)
    {
        if ($comment->user_id !== auth()->id() && auth()->user()->role !== 'admin') abort(403);

        $comment->delete();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Komentar dihapus.'
            ]);
        }

        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}