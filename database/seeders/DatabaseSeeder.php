<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun-akun awal sengaja dikosongkan agar Anda bisa Register sendiri dari halaman web.
        // Jika butuh Admin, Anda bisa ubah 'role' menjadi 'admin' langsung melalui MySQL Workbench.
    }
}