<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    // TAMPIL DATA
    public function index()
    {
        // Update denda real-time untuk anggota yang terlambat
        $peminjamanTerlambat = Peminjaman::where('status', 'dipinjam')
            ->whereDate('tanggal_kembali', '<', now())
            ->pluck('anggota_id')
            ->unique();

        foreach ($peminjamanTerlambat as $anggotaId) {
            Peminjaman::updateDendaAnggota($anggotaId);
        }

        $peminjaman = Peminjaman::with(['anggota', 'buku'])->get();

        return view('peminjaman.index', compact('peminjaman'));
    }

    // FORM TAMBAH
    public function create()
    {
        $anggota = Anggota::all();
        $buku = Buku::with('kategori')->get();

        return view('peminjaman.create', compact('anggota', 'buku'));
    }

    // SIMPAN DATA
    public function store(Request $request)
    {
        // Cek sanksi dinamis sebelum menambah peminjaman
        if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role !== 'admin') {
            /** @var \App\Models\User $currentUser */
            $currentUser = \Illuminate\Support\Facades\Auth::user();
            $sanksi = $currentUser->cekStatusSanksi();
            if (in_array($sanksi['status'], ['suspended', 'frozen'])) {
                return back()->with('error', 'Transaksi DITOLAK! Akun ditangguhkan karena denda belum lunas. Silakan lunasi terlebih dahulu.');
            }
        }
        try {
            $request->validate([
                'anggota_id' => 'required',
                'buku_id' => 'required',
                'tanggal_pinjam' => 'required',
                'tanggal_kembali' => 'required',
            ]);

            DB::transaction(function () use ($request) {
                // Gunakan lockForUpdate untuk menghindari race condition
                $buku = Buku::where('id', $request->buku_id)->lockForUpdate()->firstOrFail();

                if ($buku->stok <= 0) {
                    throw new \Exception('Stok buku habis!');
                }

                Peminjaman::create([
                    'anggota_id' => $request->anggota_id,
                    'buku_id' => $request->buku_id,
                    'tanggal_pinjam' => $request->tanggal_pinjam,
                    'tanggal_kembali' => $request->tanggal_kembali,
                    'status' => 'dipinjam',
                ]);

                // Kurangi stok
                $buku->stok -= 1;

                // Jika stok habis, ubah status menjadi dipinjam (alias Tidak Tersedia)
                if ($buku->stok <= 0) {
                    $buku->status = 'dipinjam';
                }

                $buku->save();
            });

            return redirect()
                ->route('peminjaman.index')
                ->with('success', 'Peminjaman berhasil');
        } catch (\Exception $e) {
            return back()
                ->with('error', $e->getMessage());
        }
    }

    // FORM EDIT
    public function edit(int $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $anggota = Anggota::all();
        $buku = Buku::with('kategori')->get();

        return view('peminjaman.edit', compact(
            'peminjaman',
            'anggota',
            'buku'
        ));
    }

    // UPDATE
    public function update(Request $request, int $id)
    {
        try {
            DB::transaction(function () use ($request, $id) {
                $peminjaman = Peminjaman::findOrFail($id);
                $statusLama = $peminjaman->getOriginal('status');

                // Jika booking disetujui menjadi dipinjam, JANGAN KURANGI STOK LAGI
                // karena stok sudah dipotong pada saat user menekan booking.
                if ($statusLama == 'booking' && $request->status == 'dipinjam') {
                    // Do nothing for stock
                }
                // Jika status berubah menjadi Dikembalikan,
                // tambahkan stok buku kembali
                elseif (
                    $statusLama == 'dipinjam' &&
                    $request->status == 'kembali'
                ) {
                    $buku = Buku::where('id', $peminjaman->buku_id)->lockForUpdate()->firstOrFail();
                    $buku->stok += 1;
                    $buku->status = 'tersedia'; // Stok bertambah, buku otomatis kembali tersedia
                    $buku->save();
                }

                $peminjaman->update([
                    'anggota_id' => $request->anggota_id,
                    'buku_id' => $request->buku_id,
                    'tanggal_pinjam' => $request->tanggal_pinjam,
                    'tanggal_kembali' => $request->tanggal_kembali,
                    'status' => $request->status,
                ]);
            });

            return redirect()
                ->route('peminjaman.index')
                ->with('success', 'Data peminjaman berhasil diperbarui');
        } catch (\Exception $e) {
            return back()
                ->with('error', $e->getMessage());
        }
    }

    // DELETE
    public function destroy(int $id)
    {
        try {
            DB::transaction(function () use ($id) {
                $pinjam = Peminjaman::findOrFail($id);

                // Kembalikan stok
                $buku = Buku::where('id', $pinjam->buku_id)->lockForUpdate()->firstOrFail();
                $buku->stok += 1;
                $buku->status = 'tersedia';
                $buku->save();

                $pinjam->delete();
            });

            return redirect()
                ->route('peminjaman.index')
                ->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
