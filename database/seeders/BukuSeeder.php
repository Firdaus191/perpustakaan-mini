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
            $kategori = Kategori::create(['kode_kategori' => 'KAT-001', 'nama_kategori' => 'Umum']);
            $kategoriIds = [$kategori->id];
        }

        $realBooks = [
            // Fiksi & Sastra
            ['judul' => 'Laskar Pelangi', 'penulis' => 'Andrea Hirata', 'penerbit' => 'Bentang Pustaka', 'tahun_terbit' => 2005],
            ['judul' => 'Bumi Manusia', 'penulis' => 'Pramoedya Ananta Toer', 'penerbit' => 'Hasta Mitra', 'tahun_terbit' => 1980],
            ['judul' => 'Cantik Itu Luka', 'penulis' => 'Eka Kurniawan', 'penerbit' => 'Gramedia', 'tahun_terbit' => 2002],
            ['judul' => 'Hujan', 'penulis' => 'Tere Liye', 'penerbit' => 'Gramedia', 'tahun_terbit' => 2016],
            ['judul' => 'Dilan 1990', 'penulis' => 'Pidi Baiq', 'penerbit' => 'Pastel Books', 'tahun_terbit' => 2014],
            ['judul' => 'Ayat-Ayat Cinta', 'penulis' => 'Habiburrahman El Shirazy', 'penerbit' => 'Republika', 'tahun_terbit' => 2004],
            ['judul' => 'Negeri 5 Menara', 'penulis' => 'Ahmad Fuadi', 'penerbit' => 'Gramedia', 'tahun_terbit' => 2009],
            ['judul' => 'Gadis Kretek', 'penulis' => 'Ratih Kumala', 'penerbit' => 'Gramedia', 'tahun_terbit' => 2012],
            ['judul' => 'Laut Bercerita', 'penulis' => 'Leila S. Chudori', 'penerbit' => 'KPG', 'tahun_terbit' => 2017],
            ['judul' => 'Pulang', 'penulis' => 'Tere Liye', 'penerbit' => 'Republika', 'tahun_terbit' => 2015],
            ['judul' => 'Aroma Karsa', 'penulis' => 'Dee Lestari', 'penerbit' => 'Bentang Pustaka', 'tahun_terbit' => 2018],
            ['judul' => 'Ronggeng Dukuh Paruk', 'penulis' => 'Ahmad Tohari', 'penerbit' => 'Gramedia', 'tahun_terbit' => 1982],
            ['judul' => 'Bumi', 'penulis' => 'Tere Liye', 'penerbit' => 'Gramedia', 'tahun_terbit' => 2014],
            ['judul' => 'Supernova', 'penulis' => 'Dee Lestari', 'penerbit' => 'Truedee', 'tahun_terbit' => 2001],
            ['judul' => 'Garis Waktu', 'penulis' => 'Fiersa Besari', 'penerbit' => 'MediaKita', 'tahun_terbit' => 2016],

            // Self-Improvement / Bisnis
            ['judul' => 'Atomic Habits', 'penulis' => 'James Clear', 'penerbit' => 'Penguin', 'tahun_terbit' => 2018],
            ['judul' => 'Filosofi Teras', 'penulis' => 'Henry Manampiring', 'penerbit' => 'Kompas', 'tahun_terbit' => 2018],
            ['judul' => 'Seni Bersikap Bodo Amat', 'penulis' => 'Mark Manson', 'penerbit' => 'HarperOne', 'tahun_terbit' => 2016],
            ['judul' => 'Think and Grow Rich', 'penulis' => 'Napoleon Hill', 'penerbit' => 'Ralston', 'tahun_terbit' => 1937],
            ['judul' => 'Rich Dad Poor Dad', 'penulis' => 'Robert Kiyosaki', 'penerbit' => 'Warner', 'tahun_terbit' => 1997],
            ['judul' => 'How to Win Friends', 'penulis' => 'Dale Carnegie', 'penerbit' => 'Simon & Schuster', 'tahun_terbit' => 1936],
            ['judul' => '7 Habits of Highly Effective People', 'penulis' => 'Stephen Covey', 'penerbit' => 'Free Press', 'tahun_terbit' => 1989],
            ['judul' => 'The Power of Habit', 'penulis' => 'Charles Duhigg', 'penerbit' => 'Random House', 'tahun_terbit' => 2012],
            ['judul' => 'Thinking, Fast and Slow', 'penulis' => 'Daniel Kahneman', 'penerbit' => 'FSG', 'tahun_terbit' => 2011],
            ['judul' => 'Mindset', 'penulis' => 'Carol S. Dweck', 'penerbit' => 'Random House', 'tahun_terbit' => 2006],

            // Teknologi & Sains
            ['judul' => 'Clean Code', 'penulis' => 'Robert C. Martin', 'penerbit' => 'Prentice Hall', 'tahun_terbit' => 2008],
            ['judul' => 'Sapiens', 'penulis' => 'Yuval Noah Harari', 'penerbit' => 'KPG', 'tahun_terbit' => 2011],
            ['judul' => 'Homo Deus', 'penulis' => 'Yuval Noah Harari', 'penerbit' => 'KPG', 'tahun_terbit' => 2015],
            ['judul' => 'Kosmos', 'penulis' => 'Carl Sagan', 'penerbit' => 'Random House', 'tahun_terbit' => 1980],
            ['judul' => 'A Brief History of Time', 'penulis' => 'Stephen Hawking', 'penerbit' => 'Bantam', 'tahun_terbit' => 1988],
            ['judul' => 'The Pragmatic Programmer', 'penulis' => 'Andy Hunt', 'penerbit' => 'Addison-Wesley', 'tahun_terbit' => 1999],
            ['judul' => 'Design Patterns', 'penulis' => 'Erich Gamma', 'penerbit' => 'Addison-Wesley', 'tahun_terbit' => 1994],
            ['judul' => 'Code Complete', 'penulis' => 'Steve McConnell', 'penerbit' => 'Microsoft Press', 'tahun_terbit' => 1993],
            ['judul' => 'The Phoenix Project', 'penulis' => 'Gene Kim', 'penerbit' => 'IT Revolution', 'tahun_terbit' => 2013],
            ['judul' => 'Head First Design Patterns', 'penulis' => 'Eric Freeman', 'penerbit' => 'OReilly', 'tahun_terbit' => 2004],

            // Biografi & Sejarah
            ['judul' => 'Steve Jobs', 'penulis' => 'Walter Isaacson', 'penerbit' => 'Simon & Schuster', 'tahun_terbit' => 2011],
            ['judul' => 'Habibie & Ainun', 'penulis' => 'B.J. Habibie', 'penerbit' => 'THC Mandiri', 'tahun_terbit' => 2010],
            ['judul' => 'Gus Dur', 'penulis' => 'Greg Barton', 'penerbit' => 'LKiS', 'tahun_terbit' => 2002],
            ['judul' => 'Madilog', 'penulis' => 'Tan Malaka', 'penerbit' => 'Pusat Data', 'tahun_terbit' => 1943],
            ['judul' => 'Bung Karno: Penyambung Lidah Rakyat', 'penulis' => 'Cindy Adams', 'penerbit' => 'Ketut', 'tahun_terbit' => 1965]
        ];

        foreach ($realBooks as $index => $book) {
            Buku::updateOrCreate(
                ['kode_buku' => 'BK-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT)],
                [
                    'judul' => $book['judul'],
                    'penulis' => $book['penulis'],
                    'penerbit' => $book['penerbit'],
                    'tahun_terbit' => $book['tahun_terbit'],
                    'kategori_id' => $faker->randomElement($kategoriIds),
                    'stok' => $faker->randomElement([5, 10, 15, 20]),
                    'status' => 'tersedia',
                    // biarkan cover image utuh jika sudah ada
                ]
            );
        }
    }
}
