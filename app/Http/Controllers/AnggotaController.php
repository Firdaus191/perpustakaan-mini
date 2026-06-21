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
        $anggota = Anggota::with('user')->get();

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
                'kode_anggota' => 'required|unique:anggotas,kode_anggota|max:50',
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'jenis_kelamin' => 'required|in:L,P',
                'alamat' => 'required|string|max:500',
                'no_hp' => 'required|numeric|digits_between:10,15',
            ]);

            // Otomatis buat akun login
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make('12345678'),
                'role' => 'user',
            ]);

            // Simpan anggota
            Anggota::create([
                'kode_anggota' => $request->kode_anggota,
                'nama' => $request->nama,
                // 'email' => $request->email, // Dihapus karena single source of truth di tabel users
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'user_id' => $user->id,
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

            // Hapus unique:anggotas,email karena email hanya ada di users
            $request->validate([
                'kode_anggota' => 'required|max:50|unique:anggotas,kode_anggota,' . $id,
                'email' => 'required|email|max:255|unique:users,email,' . ($anggota->user_id ?? 0),
                'nama' => 'required|string|max:255',
                'jenis_kelamin' => 'required|in:L,P',
                'alamat' => 'required|string|max:500',
                'no_hp' => 'required|numeric|digits_between:10,15',
            ]);

            $anggota->update([
                'kode_anggota' => $request->kode_anggota,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
            ]);

            // Update juga data user jika ada
            if ($anggota->user) {
                $anggota->user->update([
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
            if ($anggota->user) {
                $anggota->user->delete();
            }

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
