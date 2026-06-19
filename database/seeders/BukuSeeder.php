<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        $kategoriIds = Kategori::pluck('id')->toArray();
        if (empty($kategoriIds)) {
            $kategori = Kategori::create(['kode_kategori' => 'KAT-001', 'nama_kategori' => 'Fiksi']);
            $kategoriIds = [$kategori->id];
        }

        $realBooks = [
            ['judul' => 'Laskar Pelangi', 'penulis' => 'Andrea Hirata', 'isbn' => '9789793062792'],
            ['judul' => 'Bumi Manusia', 'penulis' => 'Pramoedya Ananta Toer', 'isbn' => '9780140255358'], // Pramoedya isbn that works
            ['judul' => 'Cantik Itu Luka', 'penulis' => 'Eka Kurniawan', 'isbn' => '9780811223638'],
            ['judul' => 'Hujan', 'penulis' => 'Tere Liye', 'isbn' => '9786020324784'],
            ['judul' => 'Filosofi Teras', 'penulis' => 'Henry Manampiring', 'isbn' => '9786024125189'],
            ['judul' => 'Dilan: Dia adalah Dilanku Tahun 1990', 'penulis' => 'Pidi Baiq', 'isbn' => '9786027870413'],
            ['judul' => 'Ayat-Ayat Cinta', 'penulis' => 'Habiburrahman El Shirazy', 'isbn' => '9789793210002'],
            ['judul' => 'Negeri 5 Menara', 'penulis' => 'Ahmad Fuadi', 'isbn' => '9789792248616'],
            ['judul' => 'Gadis Kretek', 'penulis' => 'Ratih Kumala', 'isbn' => '9789792281415'],
            ['judul' => 'Tetralogi Buru', 'penulis' => 'Pramoedya Ananta Toer', 'isbn' => '9780140255358'],
        ];

        // hapus baris ini

        $booksCount = count($realBooks);
        for ($i = 0; $i < 20; $i++) {
            if ($i < $booksCount) {
                $judul = $realBooks[$i]['judul'];
                $penulis = $realBooks[$i]['penulis'];
                $isbn = $realBooks[$i]['isbn'];
                $cover = "https://covers.openlibrary.org/b/isbn/{$isbn}-M.jpg";
            } else {
                $judul = ucwords($faker->words(3, true));
                $penulis = $faker->name;
                $cover = "https://covers.openlibrary.org/b/id/" . $faker->numberBetween(1000000, 9000000) . "-M.jpg";
            }

            Buku::create([
                'kode_buku' => 'BK-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'judul' => $judul,
                'penulis' => $penulis,
                'penerbit' => $faker->company,
                'tahun_terbit' => $faker->year,
                'kategori_id' => $faker->randomElement($kategoriIds),
                'stok' => $faker->numberBetween(5, 20),
                'status' => 'tersedia',
                'cover_image' => $cover,
            ]);
        }
    }
}
