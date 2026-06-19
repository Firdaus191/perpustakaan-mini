<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;

class PengembalianController extends Controller
{
    // Halaman Pengembalian
    public function index()
    {
        // Buku yang masih dipinjam atau menunggu pengembalian
        $dipinjam = Peminjaman::with(['anggota', 'buku'])
            ->whereIn('status', ['dipinjam', 'menunggu_pengembalian'])
            ->orderBy('id', 'desc')
            ->get();

        foreach ($dipinjam as $trx) {
            $jatuhTempo = \Carbon\Carbon::parse($trx->tanggal_kembali)->startOfDay();
            $hariIni = \Carbon\Carbon::now()->startOfDay();
            $trx->telat_hari = 0;
            $trx->total_denda = 0;
            if ($hariIni->greaterThan($jatuhTempo) && $trx->status == 'dipinjam') {
                $trx->telat_hari = $jatuhTempo->diffInDays($hariIni);
                $trx->total_denda = $trx->telat_hari * 2000;
            }
        }

        // Buku yang sudah dikembalikan
        $dikembalikan = Peminjaman::with(['anggota', 'buku'])
            ->where('status', 'kembali')
            ->orderBy('id', 'desc')
            ->get();

        return view(
            'pengembalian.index',
            compact(
                'dipinjam',
                'dikembalikan'
            )
        );
    }

    // Proses Pengembalian
    public function kembalikan(int $id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        if ($pinjam->status == 'Dipinjam') {

            $pinjam->update([
                'status' => 'Dikembalikan'
            ]);

            $pinjam->buku->increment('stok');
        }

        return redirect()
            ->route('pengembalian.index')
            ->with(
                'success',
                'Buku berhasil dikembalikan.'
            );
    }
}