<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggotas';

    protected $fillable = [
        'kode_anggota',
        'nama',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'email'
    ];
}