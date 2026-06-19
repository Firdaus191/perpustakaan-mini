<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    // TAMPIL DATA
    public function index()
    {
        $anggota = Anggota::all();

        return view('anggota.index', compact('anggota'));
    }

    // FORM TAMBAH
    public function create()
    {
        return view('anggota.create');
    }

    // SIMPAN DATA
    public function store(Request $request)
    {
        try {

            $request->validate([
                'kode_anggota' => 'required|unique:anggotas,kode_anggota',
                'nama' => 'required',
                'email' => 'required|email|unique:anggotas,email|unique:users,email',
                'jenis_kelamin' => 'required',
                'alamat' => 'required',
                'no_hp' => 'required',
            ]);

            // Simpan anggota
            Anggota::create([
                'kode_anggota' => $request->kode_anggota,
                'nama' => $request->nama,
                'email' => $request->email,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
            ]);

            // Otomatis buat akun login
            User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make('12345678'),
                'role' => 'user',
            ]);

            return redirect()
                ->route('anggota.index')
                ->with(
                    'success',
                    'Data anggota berhasil ditambahkan. Password login default: 12345678'
                );

        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', 'Gagal: ' . $e->getMessage());

        }
    }

    // FORM EDIT
    public function edit(int $id)
    {
        $anggota = Anggota::findOrFail($id);

        return view('anggota.edit', compact('anggota'));
    }

    // UPDATE
    public function update(Request $request, int $id)
    {
        try {

            $anggota = Anggota::findOrFail($id);

            $request->validate([
                'kode_anggota' => 'required|unique:anggotas,kode_anggota,' . $id,
                'email' => 'required|email',
                'nama' => 'required',
                'jenis_kelamin' => 'required',
                'alamat' => 'required',
                'no_hp' => 'required',
            ]);

            $anggota->update([
                'kode_anggota' => $request->kode_anggota,
                'nama' => $request->nama,
                'email' => $request->email,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
            ]);

            // Update juga data user jika ada
            $user = User::where('email', $anggota->email)->first();

            if ($user) {
                $user->update([
                    'name' => $request->nama,
                    'email' => $request->email,
                ]);
            }

            return redirect()
                ->route('anggota.index')
                ->with('success', 'Data anggota berhasil diperbarui');

        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', 'Gagal update: ' . $e->getMessage());

        }
    }

    // DELETE
    public function delete(int $id)
    {
        try {

            $anggota = Anggota::findOrFail($id);

            // Hapus akun user jika ada
            User::where('email', $anggota->email)->delete();

            // Hapus anggota
            $anggota->delete();

            return redirect()
                ->route('anggota.index')
                ->with('success', 'Data anggota berhasil dihapus');

        } catch (\Exception $e) {

            return redirect()
                ->route('anggota.index')
                ->with('error', 'Gagal menghapus data');

        }
    }
}