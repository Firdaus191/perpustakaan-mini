<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukus', function (Blueprint $table) {

            $table->id();

            $table->string('kode_buku',20)->unique();

            $table->string('judul');

            $table->string('penulis');

            $table->string('penerbit');

            $table->year('tahun_terbit');

            $table->foreignId('kategori_id')
                ->constrained('kategoris')
                ->cascadeOnDelete();

            $table->integer('stok')->default(0);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};