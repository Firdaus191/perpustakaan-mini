<?php

namespace Database\Factories;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Buku>
 */
class BukuFactory extends Factory
{
    protected $model = Buku::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Buat kategori jika belum ada untuk FK
        $kategori = Kategori::inRandomOrder()->first();
        if (!$kategori) {
            $kategori = Kategori::create([
                'kode_kategori' => 'KAT-' . $this->faker->unique()->randomNumber(3),
                'nama_kategori' => $this->faker->word(),
                'keterangan' => 'Kategori otomatis oleh BukuFactory'
            ]);
        }

        return [
            'kode_buku' => 'BK-' . $this->faker->unique()->randomNumber(4),
            'judul' => $this->faker->sentence(3),
            'penulis' => $this->faker->name(),
            'penerbit' => $this->faker->company(),
            'tahun_terbit' => $this->faker->year(),
            'kategori_id' => $kategori->id,
            'stok' => $this->faker->numberBetween(1, 20),
            'cover_image' => null,
            'status' => $this->faker->randomElement(['tersedia', 'dipinjam']),
        ];
    }
}
