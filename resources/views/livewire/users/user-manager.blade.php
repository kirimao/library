<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-display text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                Manajemen Pustakawan &amp; Admin
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1 font-medium">
                Pendaftaran akun petugas perpustakaan dan kelola hak akses sistem
            </p>
        </div>

        <button wire:click="openCreateModal"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-xs sm:text-sm shadow-md hover:shadow-lg hover:-translate-y-0.5 active:scale-95 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Tambah Pustakawan Baru
        </button>
    </div>

    {{-- Alert Flash Messages --}}
    @if (session()->has('message'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-sm font-semibold flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="p-4 rounded-2xl bg-red-50 border border-red-200/80 text-red-800 text-sm font-semibold flex items-center gap-3">
            <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Filter Bar --}}
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row gap-3 items-center justify-between">
        <div class="relative w-full sm:w-80">
            <input wire:model.live.debounce.300ms="search" type="text"
                   placeholder="Cari nama atau email..."
                   class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>

        <div class="flex items-center gap-2 w-full sm:w-auto">
            <select wire:model.live="roleFilter" class="w-full sm:w-auto px-3.5 py-2 rounded-xl border border-slate-300 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <option value="">Semua Peran</option>
                <option value="admin">Administrator</option>
                <option value="librarian">Pustakawan</option>
            </select>
        </div>
    </div>

    {{-- Users Table --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50 border-b border-slate-200/80 text-xs uppercase font-extrabold text-slate-500 tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Pengguna</th>
                        <th class="px-6 py-4">Peran</th>
                        <th class="px-6 py-4">Tanggal Dibuat</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($users as $u)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-teal-700 text-white font-black text-sm flex items-center justify-center flex-shrink-0 shadow-sm">
                                        {{ strtoupper(substr($u->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 leading-snug flex items-center gap-2">
                                            {{ $u->name }}
                                            @if($u->id === Auth::id())
                                                <span class="text-[10px] bg-emerald-100 text-emerald-800 font-extrabold px-2 py-0.5 rounded-full border border-emerald-200">
                                                    Anda
                                                </span>
                                            @endif
                                        </p>
                                        <p class="text-xs text-slate-400 font-normal">{{ $u->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($u->role === 'admin')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-purple-50 text-purple-700 border border-purple-200">
                                        👑 Administrator
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        📚 Pustakawan
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500">
                                {{ $u->created_at ? $u->created_at->format('d M Y, H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Reset Password Button --}}
                                    <button wire:click="openResetPasswordModal({{ $u->id }})"
                                            title="Reset Kata Sandi"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 transition-all">
                                        🔑 Reset Sandi
                                    </button>

                                    {{-- Delete Button (Disabled if self) --}}
                                    @if($u->id !== Auth::id())
                                        <button wire:click="confirmDelete({{ $u->id }})"
                                                title="Hapus Akun"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-red-600 hover:bg-red-700 shadow-sm transition-all">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Hapus
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400 font-medium">
                                Tidak ada data akun pustakawan ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    {{-- MODAL 1: Tambah Pustakawan / Admin Baru --}}
    @if($showCreateModal)
        <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-slate-200">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-display text-xl font-black text-slate-900 flex items-center gap-2">
                        <span>✨</span> Tambah Akun Petugas
                    </h3>
                    <button wire:click="$set('showCreateModal', false)" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form wire:submit="createUser" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Nama Lengkap</label>
                        <input wire:model="name" type="text" placeholder="Contoh: Budi Santoso"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        @error('name') <span class="text-xs text-red-600 mt-1 block font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Alamat Email</label>
                        <input wire:model="email" type="email" placeholder="budi@ypa.sch.id"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        @error('email') <span class="text-xs text-red-600 mt-1 block font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Peran / Hak Akses</label>
                        <select wire:model="role" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                            <option value="librarian">📚 Pustakawan (Kelola Buku, Anggota, Sirkulasi)</option>
                            <option value="admin">👑 Administrator (Akses Penuh Sistem)</option>
                        </select>
                        @error('role') <span class="text-xs text-red-600 mt-1 block font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Kata Sandi</label>
                        <input wire:model="password" type="password" placeholder="Minimal 8 karakter"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        @error('password') <span class="text-xs text-red-600 mt-1 block font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Konfirmasi Kata Sandi</label>
                        <input wire:model="password_confirmation" type="password" placeholder="Ulangi kata sandi"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" wire:click="$set('showCreateModal', false)"
                                class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200">
                            Batal
                        </button>
                        <button type="submit"
                                class="px-5 py-2.5 rounded-xl text-xs font-extrabold text-white bg-brand-600 hover:bg-brand-700 shadow-md">
                            Simpan Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- MODAL 2: Reset Password --}}
    @if($showResetPasswordModal)
        <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-slate-200">
                <h3 class="font-display text-lg font-black text-slate-900 mb-2">
                    🔑 Reset Sandi — {{ $selectedUserName }}
                </h3>
                <p class="text-xs text-slate-500 mb-4">
                    Masukkan kata sandi baru untuk akun petugas ini.
                </p>

                <form wire:submit="resetPassword" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Kata Sandi Baru</label>
                        <input wire:model="newPassword" type="password" placeholder="Minimal 8 karakter" autofocus
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        @error('newPassword') <span class="text-xs text-red-600 mt-1 block font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" wire:click="$set('showResetPasswordModal', false)"
                                class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200">
                            Batal
                        </button>
                        <button type="submit"
                                class="px-5 py-2.5 rounded-xl text-xs font-extrabold text-white bg-brand-600 hover:bg-brand-700 shadow-md">
                            Perbarui Sandi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- MODAL 3: Konfirmasi Hapus --}}
    @if($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-slate-200 text-center">
                <div class="w-14 h-14 rounded-2xl bg-red-50 text-red-600 mx-auto flex items-center justify-center mb-4 border border-red-100">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <h3 class="font-display text-xl font-black text-slate-900 mb-2">Hapus Akun Petugas?</h3>
                <p class="text-xs sm:text-sm text-slate-500 mb-6">
                    Apakah Anda yakin ingin menghapus akun <span class="font-bold text-slate-800">"{{ $selectedUserName }}"</span>? Tindakan ini tidak dapat dibatalkan.
                </p>

                <div class="flex items-center justify-center gap-3">
                    <button type="button" wire:click="$set('showDeleteModal', false)"
                            class="w-full py-2.5 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200">
                        Batal
                    </button>
                    <button type="button" wire:click="deleteUser"
                            class="w-full py-2.5 rounded-xl text-xs font-extrabold text-white bg-red-600 hover:bg-red-700 shadow-md">
                        Ya, Hapus Akun
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
