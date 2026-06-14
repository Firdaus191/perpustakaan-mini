<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Dashboard User
    public function dashboard()
    {
        return view('user.dashboard');
    }

    // Daftar Buku
    public function buku()
    {
        $buku = Buku::all();

        // Cari data anggota berdasarkan email user login
        $anggota = Anggota::where(
            'email',
            Auth::user()->email
        )->first();

        $dipinjam = [];

        if ($anggota) {

            $dipinjam = Peminjaman::where(
                'anggota_id',
                $anggota->id
            )
            ->where('status', 'Dipinjam')
            ->pluck('buku_id')
            ->toArray();

        }

        return view(
            'user.buku',
            compact('buku', 'dipinjam')
        );
    }


    // Riwayat Peminjaman
    public function riwayat()
    {
        // Cari anggota berdasarkan email user login
        $anggota = Anggota::where(
            'email',
            Auth::user()->email
        )->first();

        if (!$anggota) {

            return back()->with(
                'error',
                'Data anggota tidak ditemukan.'
            );

        }

        // Ambil riwayat peminjaman
        $riwayat = Peminjaman::with('buku')
            ->where('anggota_id', $anggota->id)
            ->orderBy('id', 'desc')
            ->get();

        return view(
            'user.riwayat',
            compact('riwayat')
        );
    }

    // Proses Pinjam Buku
    public function pinjam($id)
    {
        // Cari anggota berdasarkan email user login
        $anggota = Anggota::where(
            'email',
            Auth::user()->email
        )->first();

        if (!$anggota) {

            return back()->with(
                'error',
                'Data anggota tidak ditemukan.'
            );

        }

        // Cari buku
        $buku = Buku::findOrFail($id);

        // Cek stok
        if ($buku->stok <= 0) {

            return back()->with(
                'error',
                'Stok buku habis.'
            );

        }

        // Cek apakah user masih meminjam buku yang sama
        $cek = Peminjaman::where('anggota_id', $anggota->id)
            ->where('buku_id', $buku->id)
            ->where('status', 'Dipinjam')
            ->first();

        if ($cek) {

            return back()->with(
                'error',
                'Anda masih meminjam buku ini.'
            );

        }

        // Simpan data peminjaman
        Peminjaman::create([

            'anggota_id'      => $anggota->id,
            'buku_id'         => $buku->id,
            'tanggal_pinjam'  => now()->toDateString(),
            'tanggal_kembali' => now()->addDays(7)->toDateString(),
            'status'          => 'Dipinjam',

        ]);

        // Kurangi stok buku
        $buku->decrement('stok');

        return back()->with(
            'success',
            'Buku berhasil dipinjam.'
        );
    }

    // Proses Kembalikan Buku
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status == 'Dipinjam') {

            $peminjaman->update([
                'status' => 'Dikembalikan'
            ]);

            $buku = Buku::find($peminjaman->buku_id);

            if ($buku) {

                $buku->increment('stok');

            }

        }

        return back()->with(
            'success',
            'Buku berhasil dikembalikan.'
        );
    }
}

