<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    // TAMPIL DATA
    public function index(Request $request)
    {
        $query = Buku::with('kategori');

        // Search
        if ($request->has('search') && $request->search != '') {
            $query->where('judul', 'like', '%' . $request->search . '%')
                ->orWhere('penulis', 'like', '%' . $request->search . '%');
        }

        // Sort
        if ($request->has('sort') && $request->has('order')) {
            $query->orderBy($request->sort, $request->order);
        } else {
            $query->latest(); // Default urutan terbaru
        }

        $buku = $query->paginate(10)->withQueryString();

        return view('buku.index', compact('buku'));
    }

    // FORM TAMBAH
    public function create()
    {
        $kategori = Kategori::all();

        return view('buku.create', compact('kategori'));
    }

    // SIMPAN DATA
    public function store(\App\Http\Requests\BukuRequest $request)
    {
        try {

            $filename = null;
            if ($request->hasFile('cover_image')) {
                $file = $request->file('cover_image');
                $filename = time() . '_' . $file->hashName();
                $file->storeAs('covers', $filename, 'public');
            }

            Buku::create([
                'kode_buku' => $request->kode_buku,
                'judul' => $request->judul,
                'penulis' => $request->penulis,
                'penerbit' => $request->penerbit,
                'tahun_terbit' => $request->tahun_terbit,
                'kategori_id' => $request->kategori_id,
                'stok' => $request->stok,
                'cover_image' => $filename,
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
    public function edit(int $id)
    {
        $buku = Buku::findOrFail($id);
        $kategori = Kategori::all();

        return view('buku.edit', compact('buku', 'kategori'));
    }

    // UPDATE
    public function update(\App\Http\Requests\BukuRequest $request, int $id)
    {
        try {

            $buku = Buku::findOrFail($id);

            $filename = $buku->cover_image;
            if ($request->hasFile('cover_image')) {
                // Hapus cover lama jika ada
                if ($buku->cover_image && Storage::disk('public')->exists('covers/' . $buku->cover_image)) {
                    Storage::disk('public')->delete('covers/' . $buku->cover_image);
                }

                $file = $request->file('cover_image');
                $filename = time() . '_' . $file->hashName();
                $file->storeAs('covers', $filename, 'public');
            }

            $buku->update([
                'kode_buku' => $request->kode_buku,
                'judul' => $request->judul,
                'penulis' => $request->penulis,
                'penerbit' => $request->penerbit,
                'tahun_terbit' => $request->tahun_terbit,
                'kategori_id' => $request->kategori_id,
                'stok' => $request->stok,
                'cover_image' => $filename,
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
    public function delete(int $id)
    {
        try {

            $buku = Buku::findOrFail($id);

            // Hapus file cover jika ada
            if ($buku->cover_image && Storage::disk('public')->exists('covers/' . $buku->cover_image)) {
                Storage::disk('public')->delete('covers/' . $buku->cover_image);
            }

            $buku->delete();

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
