<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        try {
            \Illuminate\Support\Facades\DB::transaction(function () use ($user, $request) {

                $user->name = $request->name;
                $user->email = $request->email;

                if ($request->filled('password')) {
                    $user->password = Hash::make($request->password);
                }

                $user->save();

                // Sinkronisasi data ke tabel anggota menggunakan relasi
                if ($user->anggota) {
                    $user->anggota->update([
                        'nama' => $request->name,
                        // 'email' => $request->email, // Dihapus karena single source of truth di tabel users
                    ]);
                }
            });

            return back()->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }
}
