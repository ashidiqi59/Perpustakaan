<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePetugas
{
    /**
     * Handle an incoming request.
     * Only allows access for 'petugas' and 'admin' roles.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (!auth()->user()->canScan()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Petugas atau Admin.');
        }

        return $next($request);
    }
}
