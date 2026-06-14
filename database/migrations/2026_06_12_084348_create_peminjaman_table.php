<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjamen', function (Blueprint $table) {

            $table->id();

            $table->foreignId('anggota_id')
                ->constrained('anggotas')
                ->cascadeOnDelete();

            $table->foreignId('buku_id')
                ->constrained('bukus')
                ->cascadeOnDelete();

            $table->date('tanggal_pinjam');

            $table->date('tanggal_kembali');

            $table->enum('status', [
                'Dipinjam',
                'Dikembalikan'
            ])->default('Dipinjam');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};