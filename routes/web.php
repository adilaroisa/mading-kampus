<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AdminArticleController;
use Illuminate\Support\Facades\Route;

// Akses Publik
Route::get('/', [ArticleController::class, 'index'])->name('home');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');

// Akses User Terautentikasi (Mahasiswa)
Route::middleware(['auth'])->group(function () {
    // Fitur Bookmark User
    Route::post('/articles/{article}/bookmark', [ArticleController::class, 'bookmark'])->name('articles.bookmark');
    Route::get('/my-bookmarks', [ArticleController::class, 'myBookmarks'])->name('bookmarks.index');
    
    // Fitur Komentar
    Route::post('/articles/{article}/comments', [ArticleController::class, 'storeComment'])->name('comments.store');
    Route::put('/comments/{comment}', [ArticleController::class, 'updateComment'])->name('comments.update');
    Route::delete('/comments/{comment}', [ArticleController::class, 'destroyComment'])->name('comments.destroy');
    
    // Profil (Bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Akses Khusus Admin (Dilindungi Middleware Auth & Admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $totalArticles = \App\Models\Article::count();
        $totalViews = \App\Models\Article::sum('views_count');
        $totalComments = \App\Models\Comment::count();
        $recentComments = \App\Models\Comment::with(['user', 'article'])->latest()->take(5)->get();
        
        return view('admin.dashboard', compact('totalArticles', 'totalViews', 'totalComments', 'recentComments'));
    })->name('dashboard');
    
    Route::get('articles/archive', [AdminArticleController::class, 'archive'])->name('articles.archive');
    Route::resource('articles', AdminArticleController::class);
});

require __DIR__.'/auth.php';