<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    // TAMPIL DATA
    public function index()
    {
        $kategori = Kategori::all();

        return view('kategori.index', compact('kategori'));
    }

    // FORM TAMBAH
    public function create()
    {
        return view('kategori.create');
    }

    // SIMPAN DATA
    public function store(Request $request)
    {
        try {

            $request->validate([
                'kode_kategori' => 'required|unique:kategoris',
                'nama_kategori' => 'required'
            ]);

            Kategori::create([
                'kode_kategori' => $request->kode_kategori,
                'nama_kategori' => $request->nama_kategori,
                'keterangan' => $request->keterangan
            ]);

            return redirect()->route('kategori.index')
                ->with('success', 'Kategori berhasil ditambahkan');

        } catch (\Exception $e) {

            return back()->with('error', $e->getMessage());
        }
    }

    // FORM EDIT
public function edit(int $id)
{
    $kategori = Kategori::findOrFail($id);

    return view('kategori.edit', compact('kategori'));
}

// UPDATE
public function update(Request $request, int $id)
{
    try {

        $request->validate([
            'kode_kategori' => 'required',
            'nama_kategori' => 'required'
        ]);

        $kategori = Kategori::findOrFail($id);

        $kategori->update([
            'kode_kategori' => $request->kode_kategori,
            'nama_kategori' => $request->nama_kategori,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui');

    } catch (\Exception $e) {

        return back()
            ->withInput()
            ->with('error', 'Gagal update: ' . $e->getMessage());

    }
}

    // DELETE
    public function delete(int $id)
    {
        Kategori::findOrFail($id)->delete();

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}