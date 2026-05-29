<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $categories = ['Akademik', 'Event', 'Beasiswa'];
        $now = now();
        
        foreach ($categories as $category) {
            DB::table('categories')->insertOrIgnore([
                'name' => $category,
                'slug' => Str::slug($category),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $categories = ['Akademik', 'Event', 'Beasiswa'];
        foreach ($categories as $category) {
            DB::table('categories')->where('slug', Str::slug($category))->delete();
        }
    }
};
