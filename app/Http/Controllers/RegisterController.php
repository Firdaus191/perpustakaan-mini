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
            'password' => 'required|string|min:8',
        ]);

        try {
            DB::transaction(function () use ($request) {
                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'user', // force role to user
                ]);

                Anggota::create([
                    'kode_anggota' => 'AGT' . rand(1000, 9999),
                    'nama' => $request->name,
                    'email' => $request->email,
                    'no_hp' => $request->no_hp,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'alamat' => '-', // default
                ]);
            });

            return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
        } catch (\Exception $e) {
            return back()->with('error', 'Registrasi gagal: ' . $e->getMessage())->withInput();
        }
    }
}
