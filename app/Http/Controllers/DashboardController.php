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
            'dipinjam'
        )->count();

        $totalPengembalian = Peminjaman::where(
            'status',
            'kembali'
        )->count();

        $totalTerlambat = Peminjaman::where('status', 'dipinjam')
            ->whereDate('tanggal_kembali', '<', now())
            ->count();

        $peminjamanTerlambat = Peminjaman::with(['anggota', 'buku'])
            ->where('status', 'dipinjam')
            ->whereDate('tanggal_kembali', '<', now())
            ->get();

        // Update denda real-time untuk semua anggota yang terlambat
        $anggotaIds = $peminjamanTerlambat->pluck('anggota_id')->unique();
        foreach ($anggotaIds as $anggotaId) {
            Peminjaman::updateDendaAnggota($anggotaId);
        }

        // Reload data setelah update denda
        $peminjamanTerlambat = Peminjaman::with(['anggota', 'buku'])
            ->where('status', 'dipinjam')
            ->whereDate('tanggal_kembali', '<', now())
            ->get();

        foreach ($peminjamanTerlambat as $trx) {
            $jatuhTempo = \Carbon\Carbon::parse($trx->tanggal_kembali)->startOfDay();
            $hariIni = \Carbon\Carbon::now()->startOfDay();
            $trx->telat_hari = (int) $jatuhTempo->diffInDays($hariIni);
            $trx->total_denda = $trx->denda;
        }

        return view(
            'dashboard',
            compact(
                'totalBuku',
                'totalKategori',
                'totalAnggota',
                'totalPeminjaman',
                'totalPengembalian',
                'totalTerlambat',
                'peminjamanTerlambat'
            )
        );
    }
}
