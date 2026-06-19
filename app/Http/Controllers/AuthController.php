<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // HALAMAN LOGIN
    public function login()
    {
        return view('auth.login');
    }

    // PROSES LOGIN
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            // Cek role
            if (Auth::user()->role == 'admin') {

                return redirect('/Perpustakaan/admin');

            } else {

                return redirect('/Perpustakaan/user');

            }
        }

        return back()->with(
            'error',
            'Email atau Password salah.'
        );
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/Perpustakaan/login');
    }
}