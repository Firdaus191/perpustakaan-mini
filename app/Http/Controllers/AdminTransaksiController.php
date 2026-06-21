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

                // Stok TIDAK DIKURANGI lagi di sini, karena sudah dikurangi (di-reservasi) 
                // pada saat user melakukan booking di UserController::pinjam()
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
                $statusDenda = 'tidak_ada';
                if ($hari_ini->greaterThan($jatuh_tempo)) {
                    $telat_hari = $jatuh_tempo->diffInDays($hari_ini);
                    $denda = $telat_hari * 2000;
                    $statusDenda = 'belum_bayar';
                }

                // Update status dan denda
                $peminjaman->update([
                    'status' => 'kembali',
                    'denda' => $denda,
                    'status_denda' => $statusDenda,
                    'tanggal_dikembalikan' => Carbon::now()
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

    // Verifikasi Pembayaran Denda (Admin)
    public function verifikasiPembayaran(int $id)
    {
        try {
            DB::transaction(function () use ($id) {
                $peminjaman = Peminjaman::findOrFail($id);

                if (!$peminjaman->bukti_pembayaran) {
                    throw new \Exception('Transaksi tidak valid untuk diverifikasi.');
                }

                // Update status denda (tanpa merubah status peminjaman buku)
                $peminjaman->update([
                    'status_denda' => 'lunas',
                ]);

                // Catatan: status_akun (suspended/frozen) dievaluasi secara dinamis
                // melalui User::cekStatusSanksi() yang dipanggil oleh Middleware.
                // Sehingga kita tidak perlu lagi mengupdate manual kolom status_akun di sini.
            });

            return back()->with('success', 'Bukti pembayaran berhasil diverifikasi. Status akun diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // Tolak Pembayaran Denda (Admin)
    public function tolakPembayaran(int $id)
    {
        try {
            DB::transaction(function () use ($id) {
                $peminjaman = Peminjaman::findOrFail($id);

                if (!$peminjaman->bukti_pembayaran) {
                    throw new \Exception('Transaksi tidak valid untuk ditolak.');
                }

                // Hapus file lama dari storage
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists('bukti/' . $peminjaman->bukti_pembayaran)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete('bukti/' . $peminjaman->bukti_pembayaran);
                }

                // Reset bukti_pembayaran menjadi null agar statusnya kembali "belum_bayar"
                $peminjaman->update([
                    'bukti_pembayaran' => null,
                    'status_denda' => 'belum_bayar'
                ]);
            });

            return back()->with('success', 'Bukti pembayaran ditolak. Status denda dikembalikan menjadi belum bayar.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
