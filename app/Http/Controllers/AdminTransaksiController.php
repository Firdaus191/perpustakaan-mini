<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminTransaksiController extends Controller
{
    // Validasi Booking
    public function validasiBooking(int $id)
    {
        try {
            DB::transaction(function () use ($id) {
                $peminjaman = Peminjaman::findOrFail($id);
                
                if ($peminjaman->status != 'booking') {
                    throw new \Exception('Status peminjaman bukan booking.');
                }

                $buku = Buku::where('id', $peminjaman->buku_id)->lockForUpdate()->firstOrFail();

                if ($buku->stok <= 0) {
                    throw new \Exception('Stok buku habis!');
                }

                // Ubah status jadi dipinjam
                $peminjaman->update([
                    'status' => 'dipinjam',
                    'tanggal_pinjam' => now()->toDateString(),
                    'tanggal_kembali' => now()->addDays(7)->toDateString(),
                ]);

                // Kurangi stok
                $buku->stok -= 1;
                if ($buku->stok <= 0) {
                    $buku->status = 'dipinjam';
                }
                $buku->save();
            });

            return back()->with('success', 'Booking berhasil divalidasi. Buku sedang dipinjam.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // Perpanjang Waktu
    public function perpanjangWaktu(int $id)
    {
        try {
            $peminjaman = Peminjaman::findOrFail($id);

            if ($peminjaman->status != 'dipinjam') {
                return back()->with('error', 'Hanya buku yang sedang dipinjam yang bisa diperpanjang.');
            }

            $tanggalBaru = Carbon::parse($peminjaman->tanggal_kembali)->addDays(7)->toDateString();
            
            $peminjaman->update([
                'tanggal_kembali' => $tanggalBaru
            ]);

            return back()->with('success', 'Waktu peminjaman berhasil diperpanjang 7 hari.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // Proses Kembali (Admin)
    public function prosesKembali(int $id)
    {
        try {
            DB::transaction(function () use ($id) {
                $peminjaman = Peminjaman::findOrFail($id);

                if (!in_array($peminjaman->status, ['dipinjam', 'menunggu_pengembalian'])) {
                    throw new \Exception('Status peminjaman tidak valid untuk dikembalikan.');
                }

                // Cek Keterlambatan
                $jatuh_tempo = Carbon::parse($peminjaman->tanggal_kembali)->startOfDay();
                $hari_ini = Carbon::now()->startOfDay();

                $denda = 0;
                if ($hari_ini->greaterThan($jatuh_tempo)) {
                    $telat_hari = $jatuh_tempo->diffInDays($hari_ini);
                    $denda = $telat_hari * 2000;
                }

                // Update status dan denda
                $peminjaman->update([
                    'status' => 'kembali',
                    'denda' => $denda,
                ]);

                // Kembalikan Stok
                $buku = Buku::where('id', $peminjaman->buku_id)->lockForUpdate()->firstOrFail();
                $buku->stok += 1;
                $buku->status = 'tersedia';
                $buku->save();
            });

            return back()->with('success', 'Buku berhasil dikembalikan dan stok bertambah.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
