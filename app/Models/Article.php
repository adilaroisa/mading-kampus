<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = ['id']; // Membuka izin mass-assignment untuk semua kolom kecuali ID

    public function category() { return $this->belongsTo(Category::class); }
    public function author() { return $this->belongsTo(User::class, 'author_id'); }
    public function comments() { return $this->hasMany(Comment::class); }
    public function favoritedBy() { return $this->belongsToMany(User::class, 'bookmarks'); }
}