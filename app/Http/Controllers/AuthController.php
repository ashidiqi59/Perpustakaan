<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Show login page
     */
    public function showLogin()
    {
        return view('login', ['page' => 'login']);
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email_or_npm' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email_or_npm)
                    ->orWhere('npm', $request->email_or_npm)
                    ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Handle remember me
            $remember = $request->has('remember');
            Auth::login($user, $remember);

            // Redirect berdasarkan role
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('success', 'Login berhasil! Selamat datang, Admin.');
            }

            return redirect()->route('home')->with('success', 'Login berhasil!');
        }

        return back()->with('error', 'Email/NPM atau password salah.');
    }

    /**
     * Show register page
     */
    public function showRegister()
    {
        return view('login', ['page' => 'register']);
    }

    /**
     * Redirect ke halaman autentikasi Google
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback dari Google OAuth
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal masuk dengan Google: ' . $e->getMessage());
        }

        // Cari berdasarkan google_id terlebih dahulu
        $user = User::where('google_id', $googleUser->getId())->first();

        if ($user) {
            // Update avatar jika ada perubahan
            if ($googleUser->getAvatar() && $user->avatar !== $googleUser->getAvatar()) {
                $user->update(['avatar' => $googleUser->getAvatar()]);
            }
            Auth::login($user, true);
        } else {
            // Cek apakah ada akun dengan email yang sama
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Tautkan google_id ke akun yang sudah ada
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $user->avatar ?: $googleUser->getAvatar(),
                    'email_verified_at' => $user->email_verified_at ?: now(),
                ]);
                Auth::login($user, true);
            } else {
                // Registrasi akun baru via Google
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'role' => User::ROLE_PENGUNJUNG,
                    'npm' => null, // Wajib dilengkapi di profil
                    'password' => null,
                    'email_verified_at' => now(),
                ]);
                Auth::login($user, true);

                return redirect()->route('profile')->with('info', 'Registrasi dengan Google berhasil! Silakan lengkapi biodata (termasuk NPM) Anda terlebih dahulu.');
            }
        }

        // Jika user belum melengkapi profil/NPM, arahkan ke halaman profil
        if (!$user->isProfileComplete()) {
            return redirect()->route('profile')->with('info', 'Selamat datang! Silakan lengkapi biodata profil Anda terlebih dahulu.');
        }

        // Arahkan ke dashboard admin jika admin, atau ke home jika pengunjung biasa
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang kembali, Admin ' . $user->name . '!');
        }

        return redirect()->route('home')->with('success', 'Selamat datang kembali, ' . $user->name . '!');
    }

    /**
     * Handle register
     */
    public function register(Request $request)
    {
        $request->validate([
            'npm' => 'required|string|unique:users,npm',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'npm' => $request->npm,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => User::ROLE_PENGUNJUNG,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');
    }

    /**
     * Handle logout
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Logout berhasil!');
    }

    /**
     * Check if NPM is available
     */
    public function checkNpm(Request $request)
    {
        $npm = $request->input('npm');
        
        if (!$npm) {
            return response()->json(['available' => false, 'message' => 'NPM tidak boleh kosong']);
        }

        $exists = User::where('npm', $npm)->exists();
        
        if ($exists) {
            return response()->json([
                'available' => false,
                'message' => 'NPM sudah terdaftar. Silakan gunakan NPM lain atau login dengan akun Anda.'
            ]);
        }

        return response()->json(['available' => true]);
    }

    /**
     * Check if Email is available
     */
    public function checkEmail(Request $request)
    {
        $email = $request->input('email');
        
        if (!$email) {
            return response()->json(['available' => false, 'message' => 'Email tidak boleh kosong']);
        }

        $exists = User::where('email', $email)->exists();
        
        if ($exists) {
            return response()->json([
                'available' => false,
                'message' => 'Email sudah terdaftar. Silakan gunakan email lain atau login dengan akun Anda.'
            ]);
        }

        return response()->json(['available' => true]);
    }
}

