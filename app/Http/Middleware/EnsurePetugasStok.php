<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePetugasStok
{
    /**
     * Handle an incoming request.
     * Only allows access for 'petugas_stok' and 'admin' roles.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = auth()->user();

        if (!$user->canManageBooks()) {
            if ($user->canScan()) {
                return redirect()->route('petugas.dashboard')
                    ->with('error', 'Akses ditolak. Halaman stok buku hanya dapat diakses oleh Petugas Stok atau Administrator.');
            }

            return redirect()->route('home')
                ->with('error', 'Akses ditolak. Halaman stok buku hanya dapat diakses oleh Petugas Stok atau Administrator.');
        }

        return $next($request);
    }
}
