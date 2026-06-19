<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $kategoris = [
            ['kode_kategori' => 'KAT-001', 'nama_kategori' => 'Fiksi', 'keterangan' => 'Buku fiksi'],
            ['kode_kategori' => 'KAT-002', 'nama_kategori' => 'Non Fiksi', 'keterangan' => 'Buku non fiksi'],
            ['kode_kategori' => 'KAT-003', 'nama_kategori' => 'Sejarah', 'keterangan' => 'Buku sejarah'],
            ['kode_kategori' => 'KAT-004', 'nama_kategori' => 'Sains', 'keterangan' => 'Buku sains'],
            ['kode_kategori' => 'KAT-005', 'nama_kategori' => 'Teknologi', 'keterangan' => 'Buku teknologi'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::firstOrCreate(['kode_kategori' => $kategori['kode_kategori']], $kategori);
        }
    }
}
