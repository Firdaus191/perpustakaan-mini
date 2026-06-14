<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggotas', function (Blueprint $table) {

            $table->id();

            $table->string('kode_anggota',20)->unique();

            $table->string('nama');

            $table->string('jenis_kelamin',1);

            $table->string('alamat');

            $table->string('no_hp',20);

            $table->string('email')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggotas');
    }
};