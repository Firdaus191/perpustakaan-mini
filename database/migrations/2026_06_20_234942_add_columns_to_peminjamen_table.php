<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('peminjamen', function (Blueprint $table) {
            $table->dateTime('tanggal_dikembalikan')->nullable();
            $table->enum('status_denda', ['tidak_ada', 'belum_bayar', 'menunggu_konfirmasi', 'lunas'])->default('tidak_ada');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjamen', function (Blueprint $table) {
            $table->dropColumn(['tanggal_dikembalikan', 'status_denda']);
        });
    }
};
