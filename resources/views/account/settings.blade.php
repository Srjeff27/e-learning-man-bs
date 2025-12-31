@extends(auth()->user()->isAdmin() ? 'layouts.admin' : (auth()->user()->isSiswa() ? 'layouts.student' : 'layouts.teacher'))

@section('title', 'Pengaturan Akun')
@section('page-title', 'Pengaturan Akun')
@section('page-subtitle', 'Kelola informasi akun dan keamanan Anda')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6 animate-fade-up">
        {{-- Profile Information Card --}}
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="p-6 border-b border-slate-200/50 dark:border-slate-700/50">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500/20 to-teal-500/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white">Informasi Profil</h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Perbarui nama, email, dan data pribadi Anda
                        </p>
                    </div>
                </div>
            </div>
            <form action="{{ route('account.update-profile') }}" method="POST"
                class="p-6 text-slate-700 dark:text-slate-300">
                @csrf
                @method('PUT')
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-semibold mb-2">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-semibold mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                        @error('email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-semibold mb-2">Nomor Telepon</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                            placeholder="08xxxxxxxxxx"
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-semibold mb-2">Role</label>
                        <input type="text" id="role" value="{{ ucfirst($user->role) }}" disabled
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 cursor-not-allowed">
                    </div>
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-semibold mb-2">Alamat</label>
                        <textarea id="address" name="address" rows="3" placeholder="Masukkan alamat lengkap..."
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all resize-none">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-semibold rounded-xl shadow-lg shadow-emerald-500/25 hover:shadow-xl transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        {{-- Avatar Card --}}
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="p-6 border-b border-slate-200/50 dark:border-slate-700/50">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-teal-500/20 to-cyan-500/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white">Foto Profil</h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Unggah foto profil Anda (maks. 2MB)</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="flex flex-col sm:flex-row items-center gap-6">
                    <div class="relative">
                        @if($user->avatar)
                            <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}"
                                class="w-24 h-24 rounded-2xl object-cover shadow-lg">
                        @else
                            <div
                                class="w-24 h-24 rounded-2xl bg-gradient-to-br from-emerald-500 to-green-600 flex items-center justify-center text-white text-3xl font-bold shadow-lg">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 space-y-3 w-full">
                        <form action="{{ route('account.update-avatar') }}" method="POST" enctype="multipart/form-data"
                            class="flex flex-col sm:flex-row gap-3">
                            @csrf
                            @method('PUT')
                            <input type="file" name="avatar" id="avatar" accept="image/*" class="block w-full text-sm text-slate-500 dark:text-slate-400
                                                    file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0
                                                    file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-600
                                                    dark:file:bg-emerald-900/30 dark:file:text-emerald-400
                                                    hover:file:bg-emerald-100 dark:hover:file:bg-emerald-900/50
                                                    file:cursor-pointer file:transition-colors">
                            <button type="submit"
                                class="px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-xl transition-colors whitespace-nowrap">
                                Upload
                            </button>
                        </form>
                        @if($user->avatar)
                            <form action="{{ route('account.remove-avatar') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-500 hover:text-red-600 font-medium">
                                    Hapus Foto
                                </button>
                            </form>
                        @endif
                        @error('avatar')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Password Card --}}
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="p-6 border-b border-slate-200/50 dark:border-slate-700/50">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-cyan-500/20 to-blue-500/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white">Ubah Password</h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Pastikan password Anda aman dan mudah diingat
                        </p>
                    </div>
                </div>
            </div>
            <form action="{{ route('account.update-password') }}" method="POST"
                class="p-6 text-slate-700 dark:text-slate-300">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="current_password" class="block text-sm font-semibold mb-2">Password Saat Ini</label>
                        <input type="password" id="current_password" name="current_password"
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-semibold mb-2">Password Baru</label>
                            <input type="password" id="password" name="password"
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                            @error('password')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold mb-2">Konfirmasi
                                Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white font-semibold rounded-xl shadow-lg shadow-cyan-500/25 hover:shadow-xl transition-all">
                        Ubah Password
                    </button>
                </div>
            </form>
        </div>

        {{-- Account Info Card --}}
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="p-6 border-b border-slate-200/50 dark:border-slate-700/50">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500/20 to-purple-500/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white">Informasi Akun</h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Detail akun dan status</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-3 gap-6">
                    <div
                        class="text-center p-4 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700">
                        <div class="text-sm text-slate-500 dark:text-slate-400 mb-1">Status</div>
                        <div
                            class="inline-flex items-center px-3 py-1 rounded-full {{ $user->is_active ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400' }}">
                            <span
                                class="w-2 h-2 rounded-full {{ $user->is_active ? 'bg-emerald-500' : 'bg-red-500' }} mr-2"></span>
                            <span class="text-sm font-semibold">{{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}</span>
                        </div>
                    </div>
                    <div
                        class="text-center p-4 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700">
                        <div class="text-sm text-slate-500 dark:text-slate-400 mb-1">Bergabung</div>
                        <div class="text-lg font-bold text-slate-900 dark:text-white">
                            {{ $user->created_at->format('d M Y') }}
                        </div>
                    </div>
                    <div
                        class="text-center p-4 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700">
                        <div class="text-sm text-slate-500 dark:text-slate-400 mb-1">Terakhir Diperbarui</div>
                        <div class="text-lg font-bold text-slate-900 dark:text-white">
                            {{ $user->updated_at->format('d M Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection