<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAccountStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return $next($request);
        }

        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();

        // Bypass for admin
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Gunakan pengecekan sanksi dinamis yang terpusat
        $statusSanksi = $user->cekStatusSanksi();

        if ($statusSanksi['status'] === 'frozen') {
            \Illuminate\Support\Facades\Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->to('/Perpustakaan/login')->with('error', 'Akun dibekukan karena keterlambatan lebih dari 30 hari. Silakan lunasi denda di perpustakaan!');
        }

        return $next($request);
    }
}
