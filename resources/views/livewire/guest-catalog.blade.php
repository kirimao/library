<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        {{-- Header Banner --}}
        <div class="bg-gradient-to-r from-brand-600 to-emerald-700 rounded-3xl p-8 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="space-y-2 text-center md:text-left">
                <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-bold uppercase tracking-wider">Katalog Publik</span>
                <h1 class="text-3xl sm:text-4xl font-black">Cari & Penjelajahan Koleksi Buku</h1>
                <p class="text-emerald-100 text-sm max-w-xl">Temukan berbagai koleksi pustaka terlengkap secara publik tanpa perlu login.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('landing') }}" class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs backdrop-blur-sm transition-all">
                    ← Halaman Utama
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl bg-white text-brand-700 hover:bg-emerald-50 font-black text-xs shadow-md transition-all">
                        Masuk Dashboard Pustakawan
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl bg-white text-brand-700 hover:bg-emerald-50 font-black text-xs shadow-md transition-all">
                        Login Petugas
                    </a>
                @endauth
            </div>
        </div>

        {{-- Filter & Search Box --}}
        <div class="bg-white border border-gray-200 rounded-3xl p-6 shadow-sm space-y-4">
            <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
                <div class="relative flex-1">
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari judul buku, penulis, penerbit, atau ISBN..." class="form-input w-full pl-11 text-sm rounded-2xl py-3 border-gray-200 shadow-sm focus:border-brand-500">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <select wire:model.live="categoryId" class="form-select rounded-xl text-xs py-2.5">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>

                    <select wire:model.live="genreId" class="form-select rounded-xl text-xs py-2.5">
                        <option value="">Semua Genre</option>
                        @foreach($genres as $gen)
                            <option value="{{ $gen->id }}">{{ $gen->name }}</option>
                        @endforeach
                    </select>

                    <select wire:model.live="availability" class="form-select rounded-xl text-xs py-2.5">
                        <option value="">Semua Status Stok</option>
                        <option value="available">Tersedia untuk Dipinjam</option>
                        <option value="unavailable">Sedang Habis Dipinjam</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Book Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($books as $b)
                <div class="bg-white border border-gray-200 rounded-3xl p-5 shadow-sm hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="w-full aspect-[3/4] rounded-2xl bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center text-slate-300 relative">
                            @if(!empty($b->cover_thumbnail))
                                <img src="{{ asset('storage/' . $b->cover_thumbnail) }}" alt="{{ $b->title }}" class="w-full h-full object-cover">
                            @elseif(!empty($b->cover_image))
                                <img src="{{ asset('storage/' . $b->cover_image) }}" alt="{{ $b->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="text-center p-4">
                                    <svg class="w-12 h-12 mx-auto text-slate-300 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <span class="text-[10px] font-semibold text-slate-400">Belum ada cover</span>
                                </div>
                            @endif

                            <div class="absolute top-3 right-3">
                                @if($b->available_copies > 0)
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-500 text-white shadow-sm">
                                        Tersedia ({{ $b->available_copies }})
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-red-500 text-white shadow-sm">
                                        Dipinjam (0)
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <span class="badge-neutral text-[10px] mb-1 inline-block">{{ $b->category->name ?? 'Umum' }}</span>
                            <h3 class="text-sm font-extrabold text-gray-900 line-clamp-2 leading-snug">{{ $b->title }}</h3>
                            <p class="text-xs text-gray-500 font-medium mt-1">Oleh {{ $b->author }}</p>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between text-[11px] text-gray-400">
                        <span>Rak: <strong class="text-gray-700 font-mono">{{ $b->shelf_location ?? '-' }}</strong></span>
                        @if($b->cover_type)
                            <span class="font-semibold text-purple-700 bg-purple-50 px-2 py-0.5 rounded-full border border-purple-100">{{ $b->cover_type }}</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center text-gray-400 space-y-2">
                    <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <p class="text-sm font-semibold">Buku tidak ditemukan sesuai kriteria pencarian.</p>
                </div>
            @endforelse
        </div>

        <div>
            {{ $books->links() }}
        </div>
    </div>
</div>
