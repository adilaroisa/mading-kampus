<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'avatar'];
    protected $hidden = ['password', 'remember_token'];
    protected function casts(): array { return ['email_verified_at' => 'datetime', 'password' => 'hashed']; }

    public function articles() { return $this->hasMany(Article::class, 'author_id'); }
    public function comments() { return $this->hasMany(Comment::class); }
    public function bookmarks() { return $this->belongsToMany(Article::class, 'bookmarks', 'user_id', 'article_id'); }
}