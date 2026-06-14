<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoris';

    protected $fillable = [
        'kode_kategori',
        'nama_kategori',
        'keterangan'
    ];

    public function buku()
    {
        return $this->hasMany(Buku::class, 'kategori_id');
    }
}