<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Anggota;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::count();

        $totalKategori = Kategori::count();

        $totalAnggota = Anggota::count();

        $totalPeminjaman = Peminjaman::where(
            'status',
            'Dipinjam'
        )->count();

        $totalPengembalian = Peminjaman::where(
            'status',
            'Dikembalikan'
        )->count();

        return view(
            'dashboard',
            compact(
                'totalBuku',
                'totalKategori',
                'totalAnggota',
                'totalPeminjaman',
                'totalPengembalian'
            )
        );
    }
}