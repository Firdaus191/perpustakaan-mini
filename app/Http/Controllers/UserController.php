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
        $anggota = Anggota::where('email', Auth::user()->email)->first();
        
        $dipinjamCount = 0;
        $jatuhTempoTerdekat = null;
        $totalDibaca = 0;
        $peminjamanAktif = collect();
        
        if ($anggota) {
            $dipinjamCount = Peminjaman::where('anggota_id', $anggota->id)
                ->whereIn('status', ['booking', 'dipinjam'])
                ->count();
                
            $peminjamanAktif = Peminjaman::with('buku')
                ->where('anggota_id', $anggota->id)
                ->whereIn('status', ['booking', 'dipinjam'])
                ->orderBy('tanggal_kembali', 'asc')
                ->get();
                
            $jatuhTempoTerdekat = Peminjaman::where('anggota_id', $anggota->id)
                ->where('status', 'dipinjam')
                ->orderBy('tanggal_kembali', 'asc')
                ->value('tanggal_kembali');
                
            $totalDibaca = Peminjaman::where('anggota_id', $anggota->id)
                ->where('status', 'kembali')
                ->count();

            // Calculate total tagihan denda
            $totalTagihanDenda = 0;
            $peminjamanTelat = Peminjaman::where('anggota_id', $anggota->id)
                ->where('status', 'dipinjam')
                ->whereDate('tanggal_kembali', '<', \Carbon\Carbon::now()->toDateString())
                ->get();
            
            foreach($peminjamanTelat as $trx) {
                $jatuhTempo = \Carbon\Carbon::parse($trx->tanggal_kembali)->startOfDay();
                $hariIni = \Carbon\Carbon::now()->startOfDay();
                if ($hariIni->greaterThan($jatuhTempo)) {
                    $totalTagihanDenda += $jatuhTempo->diffInDays($hariIni) * 2000;
                }
            }
        }

        $rekomendasiBuku = Buku::where('status', 'tersedia')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return view('user.dashboard', compact(
            'dipinjamCount', 
            'jatuhTempoTerdekat', 
            'totalTagihanDenda', 
            'peminjamanAktif', 
            'rekomendasiBuku'
        ));
    }

    // Daftar Buku
    public function buku()
    {
        $buku = Buku::with('kategori')->when(request('search'), function($query) {
            $query->where('judul', 'like', '%' . request('search') . '%');
        })->paginate(10);

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
            ->whereIn('status', ['booking', 'dipinjam'])
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
    public function pinjam(int $id)
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

        // Cek apakah user masih meminjam atau booking buku yang sama
        $cek = Peminjaman::where('anggota_id', $anggota->id)
            ->where('buku_id', $buku->id)
            ->whereIn('status', ['booking', 'dipinjam'])
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
            'status'          => 'booking',

        ]);

        return back()->with(
            'success',
            'Buku berhasil dibooking, menunggu validasi admin.'
        );
    }

    // Proses Kembalikan Buku
    public function kembalikan(int $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status == 'dipinjam') {

            $peminjaman->update([
                'status' => 'menunggu_pengembalian'
            ]);

        }

        return back()->with(
            'success',
            'Permintaan pengembalian dikirim, menunggu admin.'
        );
    }
}

