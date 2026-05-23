<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('category', 'author')->orderByDesc('is_pinned')->latest()->paginate(9);
        return view('welcome', compact('articles'));
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->with(['comments.user', 'category', 'author'])->firstOrFail();
        
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
        $request->validate(['body' => 'required|min:3']);

        Comment::create([
            'article_id' => $article->id,
            'user_id' => auth()->id(),
            'body' => $request->body
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function updateComment(Request $request, Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) abort(403);

        $request->validate(['body' => 'required|min:3']);

        $comment->update([
            'body' => $request->body,
            'is_edited' => true
        ]);

        return back()->with('success', 'Komentar berhasil diperbarui.');
    }

    public function destroyComment(Comment $comment)
    {
        if ($comment->user_id !== auth()->id() && auth()->user()->role !== 'admin') abort(403);

        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}