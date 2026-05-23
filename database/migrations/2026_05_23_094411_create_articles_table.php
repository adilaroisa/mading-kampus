<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->string('image')->nullable();
            $table->boolean('is_pinned')->default(false);
            $table->integer('views_count')->default(0);
            
            // Foreign Keys
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            // Author ID merujuk ke tabel users
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade'); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};