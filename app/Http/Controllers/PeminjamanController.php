<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;

class PeminjamanController extends Controller
{
    // TAMPIL DATA
    public function index()
    {
        $peminjaman = Peminjaman::with(['anggota', 'buku'])->get();

        return view('peminjaman.index', compact('peminjaman'));
    }

    // FORM TAMBAH
    public function create()
    {
        $anggota = Anggota::all();
        $buku = Buku::all();

        return view('peminjaman.create', compact('anggota', 'buku'));
    }

    // SIMPAN DATA
    public function store(Request $request)
    {
        try {

            $request->validate([
                'anggota_id' => 'required',
                'buku_id' => 'required',
                'tanggal_pinjam' => 'required',
                'tanggal_kembali' => 'required',
            ]);

            $buku = Buku::findOrFail($request->buku_id);

            if ($buku->stok <= 0) {
                return back()->with('error', 'Stok buku habis!');
            }

            Peminjaman::create([
                'anggota_id' => $request->anggota_id,
                'buku_id' => $request->buku_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali' => $request->tanggal_kembali,
                'status' => 'Dipinjam',
            ]);

            // Kurangi stok
            $buku->decrement('stok');

            return redirect()
                ->route('peminjaman.index')
                ->with('success', 'Peminjaman berhasil');

        } catch (\Exception $e) {

            return back()
                ->with('error', $e->getMessage());

        }
    }

    // FORM EDIT
    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $anggota = Anggota::all();
        $buku = Buku::all();

        return view('peminjaman.edit', compact(
            'peminjaman',
            'anggota',
            'buku'
        ));
    }

    // UPDATE
  public function update(Request $request, $id)
{
    try {

        $peminjaman = Peminjaman::findOrFail($id);

        // Jika status berubah menjadi Dikembalikan,
        // tambahkan stok buku kembali
        if (
            $peminjaman->status == 'Dipinjam' &&
            $request->status == 'Dikembalikan'
        ) {
            $peminjaman->buku->increment('stok');
        }

        $peminjaman->update([
            'anggota_id' => $request->anggota_id,
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil diperbarui');

    } catch (\Exception $e) {

        return back()
            ->with('error', $e->getMessage());

    }
}

    // DELETE
    public function delete($id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        // Kembalikan stok
        $pinjam->buku->increment('stok');

        $pinjam->delete();

        return redirect()
            ->route('peminjaman.index')
            ->with('success', 'Data berhasil dihapus');
    }
}