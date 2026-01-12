<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        return back()->withErrors([
            'email_or_npm' => 'Email/NPM atau password salah.',
        ]);
    }

    /**
     * Show register page
     */
    public function showRegister()
    {
        return view('register');
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

        $user = User::create([
            'npm' => $request->npm,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => User::ROLE_PENGUNJUNG, 
        ]);

        Auth::login($user);
        return redirect()->route('home')->with('success', 'Registrasi berhasil!');
    }

    /**
     * Handle logout
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Logout berhasil!');
    }
}

