<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Anggota;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1 akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@perpus.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 1 akun User biasa
        $user = User::create([
            'name' => 'User Biasa',
            'email' => 'user@perpus.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Karena tabel users dan anggotas tidak memiliki relasi foreign key secara langsung,
        // kita membuat data anggota dengan email yang sama untuk user tersebut.
        Anggota::create([
            'kode_anggota' => 'ANG-001',
            'nama' => $user->name,
            'jenis_kelamin' => 'L', // Misalkan L
            'alamat' => 'Jl. Pustaka No. 1',
            'no_hp' => '081234567890',
            'email' => $user->email,
        ]);

        // Memanggil seeder
        $this->call([
            KategoriSeeder::class,
            BukuSeeder::class,
        ]);
    }
}
