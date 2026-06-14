<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;

class BukuController extends Controller
{
    // TAMPIL DATA
    public function index()
    {
        $buku = Buku::with('kategori')->get();

        return view('buku.index', compact('buku'));
    }

    // FORM TAMBAH
    public function create()
    {
        $kategori = Kategori::all();

        return view('buku.create', compact('kategori'));
    }

    // SIMPAN DATA
    public function store(Request $request)
    {
        try {

            $request->validate([
                'kode_buku' => 'required|unique:bukus',
                'judul' => 'required',
                'penulis' => 'required',
                'penerbit' => 'required',
                'tahun_terbit' => 'required',
                'kategori_id' => 'required',
                'stok' => 'required'
            ]);

            Buku::create([
                'kode_buku' => $request->kode_buku,
                'judul' => $request->judul,
                'penulis' => $request->penulis,
                'penerbit' => $request->penerbit,
                'tahun_terbit' => $request->tahun_terbit,
                'kategori_id' => $request->kategori_id,
                'stok' => $request->stok,
            ]);

            return redirect()
                ->route('buku.index')
                ->with('success', 'Data buku berhasil ditambahkan');

        } catch (\Exception $e) {

            return back()
                ->with('error', 'Gagal: ' . $e->getMessage());

        }
    }

    // FORM EDIT
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategori = Kategori::all();

        return view('buku.edit', compact('buku', 'kategori'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        try {

            $buku = Buku::findOrFail($id);

            $buku->update([
                'kode_buku' => $request->kode_buku,
                'judul' => $request->judul,
                'penulis' => $request->penulis,
                'penerbit' => $request->penerbit,
                'tahun_terbit' => $request->tahun_terbit,
                'kategori_id' => $request->kategori_id,
                'stok' => $request->stok,
            ]);

            return redirect()
                ->route('buku.index')
                ->with('success', 'Data buku berhasil diperbarui');

        } catch (\Exception $e) {

            return back()
                ->with('error', 'Gagal update: ' . $e->getMessage());

        }
    }

    // DELETE
    public function delete($id)
    {
        try {

            Buku::findOrFail($id)->delete();

            return redirect()
                ->route('buku.index')
                ->with('success', 'Data buku berhasil dihapus');

        } catch (\Exception $e) {

            return redirect()
                ->route('buku.index')
                ->with('error', 'Gagal menghapus data');

        }
    }
}