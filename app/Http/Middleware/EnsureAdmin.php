<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Handle an incoming request.
     * Only allows access for 'admin' role.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = auth()->user();

        if (!$user->isAdmin()) {
            if ($user->isPetugas()) {
                return redirect()->route('petugas.dashboard')
                    ->with('error', 'Akses ditolak. Halaman admin hanya dapat diakses oleh Administrator.');
            }

            return redirect()->route('home')
                ->with('error', 'Akses ditolak. Halaman admin hanya dapat diakses oleh Administrator.');
        }

        return $next($request);
    }
}
