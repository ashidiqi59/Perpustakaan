<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        $search = $request->search ?? '';
        $role   = $request->role ?? 'all';
        
        $query = User::query();
        
        if ($role && in_array($role, ['admin', 'petugas', 'pengunjung'])) {
            $query->where('role', $role);
        }
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('npm', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Count totals for each group
        $counts = [
            'all'        => User::count(),
            'admin'      => User::where('role', 'admin')->count(),
            'petugas'    => User::where('role', 'petugas')->count(),
            'pengunjung' => User::where('role', 'pengunjung')->count(),
        ];
        
        // Sort with Admin first, then Petugas, then Pengunjung
        $users = $query->orderByRaw("CASE 
            WHEN role = 'admin' THEN 1 
            WHEN role = 'petugas' THEN 2 
            WHEN role = 'pengunjung' THEN 3 
            ELSE 4 END")
            ->latest('id')
            ->paginate(10)
            ->withQueryString();
        
        return view('admin.users.index', compact('users', 'search', 'role', 'counts'));
    }

    /**
     * Show the form for creating a new user (petugas only).
     */
    public function create()
    {
        return view('admin.users.form', [
            'user'   => null,
            'action' => 'create',
        ]);
    }

    /**
     * Store a newly created user (petugas) in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'npm'      => 'nullable|string|max:20|unique:users,npm',
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'role'     => 'required|in:admin,petugas,pengunjung',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users.form', [
            'user'   => $user,
            'action' => 'edit',
        ]);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'npm'      => 'nullable|string|max:20|unique:users,npm,' . $user->id,
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'role'     => 'required|in:admin,petugas,pengunjung',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        // Only update password if provided
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }
}

