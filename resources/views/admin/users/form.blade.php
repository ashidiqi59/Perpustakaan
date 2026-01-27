@extends('layouts.admin')

@section('title', 'Edit User')
@section('subtitle', 'Perbarui informasi user')

@section('header-actions')
    <a href="{{ route('admin.users.index') }}" class="px-3 py-2 sm:px-4 sm:py-2 bg-slate-500 text-white text-xs sm:text-sm rounded-lg hover:bg-slate-600 transition-colors flex items-center gap-1 sm:gap-2">
        <i class="fas fa-arrow-left"></i>
        <span class="hidden sm:inline">Kembali</span>
    </a>
@endsection

@section('content')
                    <!-- ALERT MESSAGES -->
                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-3 rounded mb-4 text-sm">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.users.update', $user->id) }}" 
                          method="POST" 
                          class="bg-white rounded-xl shadow-sm overflow-hidden max-w-2xl">
                        @csrf
                        @method('PUT')

                        <div class="p-4 sm:p-6 space-y-4">
                            <!-- User Avatar -->
                            <div class="flex items-center gap-3 sm:gap-4 mb-4 sm:mb-6">
                                <div class="w-14 h-14 sm:w-20 sm:h-20 bg-blue-100 rounded-full flex items-center justify-center shrink-0">
                                    <i class="fas fa-user text-blue-500 text-xl sm:text-3xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-base sm:text-lg font-semibold text-slate-800">{{ $user->name }}</h3>
                                    <p class="text-xs sm:text-sm text-slate-500">{{ $user->npm }}</p>
                                </div>
                            </div>

                            <!-- NPM -->
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-slate-600 mb-1">NPM *</label>
                                <input type="text" name="npm" value="{{ old('npm', $user->npm) }}" required
                                    class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Masukkan NPM">
                            </div>

                            <!-- Name -->
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-slate-600 mb-1">Nama Lengkap *</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                    class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Masukkan nama lengkap">
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-slate-600 mb-1">Email *</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Masukkan email">
                            </div>

                            <!-- Role -->
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-slate-600 mb-1">Role *</label>
                                <select name="role" required
                                    class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Pilih Role</option>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="pengunjung" {{ old('role', $user->role) == 'pengunjung' ? 'selected' : '' }}>Pengunjung</option>
                                </select>
                            </div>

                            <!-- Password (Optional) -->
                            <div class="border-t border-slate-200 pt-4 mt-4">
                                <h4 class="font-medium text-slate-800 mb-3 sm:mb-4 text-sm">
                                    <i class="fas fa-key mr-2"></i>Ubah Password (Opsional)
                                </h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs sm:text-sm font-medium text-slate-600 mb-1">Password Baru</label>
                                        <input type="password" name="password"
                                            class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="Kosongkan jika tidak diubah">
                                    </div>
                                    <div>
                                        <label class="block text-xs sm:text-sm font-medium text-slate-600 mb-1">Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation"
                                            class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="Konfirmasi password baru">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- FORM ACTIONS -->
                        <div class="px-4 py-3 sm:px-6 sm:py-4 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row justify-end gap-2 sm:gap-3">
                            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-slate-500 text-white text-sm rounded-lg hover:bg-slate-600 transition-colors text-center">
                                Batal
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600 transition-colors flex items-center justify-center gap-2">
                                <i class="fas fa-save"></i>
                                Perbarui User
                            </button>
                        </div>
                    </form>
@endsection

