<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;

class PengembalianController extends Controller
{
    // Halaman Pengembalian
    public function index()
    {
        // Buku yang masih dipinjam
        $dipinjam = Peminjaman::with(['anggota', 'buku'])
            ->where('status', 'Dipinjam')
            ->orderBy('id', 'desc')
            ->get();

        // Buku yang sudah dikembalikan
        $dikembalikan = Peminjaman::with(['anggota', 'buku'])
            ->where('status', 'Dikembalikan')
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
    public function kembalikan($id)
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