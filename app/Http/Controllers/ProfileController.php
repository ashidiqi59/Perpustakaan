<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil dan kelengkapan biodata pengguna.
     */
    public function show()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    /**
     * Perbarui data biodata profil pengguna.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'npm' => [
                'required',
                'string',
                'max:30',
                Rule::unique('users', 'npm')->ignore($user->id),
            ],
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:25',
            'prodi' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
        ], [
            'npm.required' => 'NPM wajib diisi sebagai identitas peminjaman buku perpustakaan.',
            'npm.unique' => 'NPM ini sudah terdaftar oleh pengguna lain.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'phone.max' => 'Nomor telepon/WhatsApp maksimal 25 karakter.',
            'prodi.max' => 'Program studi maksimal 100 karakter.',
        ]);

        $user->update($validated);

        return redirect()->route('profile')->with('success', 'Biodata profil berhasil disimpan!');
    }

    /**
     * Atur atau ganti password pengguna (berguna bagi akun Google yang ingin login via NPM/Password).
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'password' => 'required|string|min:6|confirmed',
        ];

        // Jika user sebelumnya sudah punya password (bukan murni Google tanpa password)
        if (!empty($user->password)) {
            $rules['current_password'] = 'required|current_password';
        }

        $request->validate($rules, [
            'current_password.current_password' => 'Password saat ini tidak cocok.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile')->with('success', 'Password berhasil diperbarui! Anda kini dapat login menggunakan NPM/Email & Password.');
    }
}
