<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Belum login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Bukan admin
        if (Auth::user()->role != 'admin') {

            abort(403, 'Akses ditolak.');

        }

        return $next($request);
    }
}