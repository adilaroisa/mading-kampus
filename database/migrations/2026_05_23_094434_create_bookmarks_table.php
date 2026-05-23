<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Primary key gabungan agar 1 user tidak bisa bookmark artikel yang sama 2 kali
            $table->primary(['article_id', 'user_id']); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
    }
};