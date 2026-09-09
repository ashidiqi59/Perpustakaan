<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventStaffAccess
{
    /**
     * Handle an incoming request.
     * Prevents admin and petugas from accessing visitor (pengunjung) pages.
     * If an admin or petugas tries to access visitor pages, force redirect them to their respective dashboard.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')
                    ->with('info', 'Anda dialihkan ke Dashboard Admin karena akun Administrator tidak mengakses halaman pengunjung.');
            }

            if ($user->isPetugas()) {
                return redirect()->route('petugas.dashboard')
                    ->with('info', 'Anda dialihkan ke Dashboard Petugas karena akun Petugas tidak mengakses halaman pengunjung.');
            }
        }

        return $next($request);
    }
}
