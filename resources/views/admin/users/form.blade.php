<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Perpustakaan | Edit User</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body class="min-h-screen bg-slate-100 text-slate-800 font-sans">
        <div class="flex h-screen">
            @include('components.sidebar')

            <!-- MAIN CONTENT -->
            <main class="flex-1 flex flex-col overflow-hidden">
                <!-- TOP BAR -->
                <header class="bg-white shadow-sm px-6 py-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-800">Edit User</h2>
                        <p class="text-sm text-slate-500">Perbarui informasi user</p>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition-colors flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </a>
                </header>

                <!-- CONTENT AREA -->
                <div class="flex-1 overflow-y-auto p-6">
                    <!-- ALERT MESSAGES -->
                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
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

                        <div class="p-6 space-y-6">
                            <!-- User Avatar -->
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-blue-500 text-3xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-800">{{ $user->name }}</h3>
                                    <p class="text-sm text-slate-500">{{ $user->npm }}</p>
                                </div>
                            </div>

                            <!-- NPM -->
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">NPM *</label>
                                <input type="text" name="npm" value="{{ old('npm', $user->npm) }}" required
                                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Masukkan NPM">
                            </div>

                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Nama Lengkap *</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Masukkan nama lengkap">
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Email *</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Masukkan email">
                            </div>

                            <!-- Role -->
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Role *</label>
                                <select name="role" required
                                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Pilih Role</option>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="pengunjung" {{ old('role', $user->role) == 'pengunjung' ? 'selected' : '' }}>Pengunjung</option>
                                </select>
                            </div>

                            <!-- Password (Optional) -->
                            <div class="border-t border-slate-200 pt-6 mt-6">
                                <h4 class="font-medium text-slate-800 mb-4">
                                    <i class="fas fa-key mr-2"></i>Ubah Password (Opsional)
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-600 mb-1">Password Baru</label>
                                        <input type="password" name="password"
                                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="Kosongkan jika tidak diubah">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-600 mb-1">Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation"
                                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="Konfirmasi password baru">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- FORM ACTIONS -->
                        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-end gap-3">
                            <a href="{{ route('admin.users.index') }}" class="px-6 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition-colors">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors flex items-center gap-2">
                                <i class="fas fa-save"></i>
                                Perbarui User
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </body>
</html>

