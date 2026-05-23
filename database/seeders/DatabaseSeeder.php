<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::create([
            'name' => 'Admin Mading',
            'email' => 'admin@umy.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Buat Akun Tim Mahasiswa
        $team = ['Dian', 'Fina', 'Sari', 'Mariska', 'Lyvia'];
        
        foreach ($team as $member) {
            User::create([
                'name' => $member,
                'email' => strtolower($member) . '@student.umy.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ]);
        }
    }
}