<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Anggota;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'no_hp' => 'required|string|max:15',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'user', // force role to user
                ]);

                $lastAnggota = Anggota::latest('id')->first();
                $nextId = $lastAnggota ? $lastAnggota->id + 1 : 1;
                $kodeAnggota = 'AGT' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

                Anggota::create([
                    'user_id' => $user->id,
                    'kode_anggota' => $kodeAnggota,
                    'nama' => $request->name,
                    // 'email' => $request->email, // Dihapus karena single source of truth di tabel users
                    'no_hp' => $request->no_hp,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'alamat' => $request->alamat,
                ]);
            });

            return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
        } catch (\Exception $e) {
            return back()->with('error', 'Registrasi gagal: ' . $e->getMessage())->withInput();
        }
    }
}
