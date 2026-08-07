<div
    class="min-h-screen bg-slate-50 text-slate-800"
    x-data="{ scrolled: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 40 })"
>

{{-- ═══════════════════════════════ 1. NAVBAR (Sticky) ═══════════════════════════════ --}}
<nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
     :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-md border-b border-slate-200/80' : 'bg-transparent'">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">

        <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
            <img src="{{ asset('images/logoypa.png') }}" alt="Logo YPA"
                 class="h-9 w-9 rounded-xl object-contain bg-white p-0.5 border border-slate-200 shadow-sm group-hover:scale-105 transition-transform duration-200">
            <div>
                <p class="font-black text-sm leading-none transition-colors duration-200"
                   :class="scrolled ? 'text-slate-900 group-hover:text-brand-600' : 'text-white'">Perpustakaan YPA</p>
                <p class="text-[10px] font-semibold mt-0.5 transition-colors duration-200"
                   :class="scrolled ? 'text-slate-400' : 'text-emerald-100'">Yayasan Peduli Anak</p>
            </div>
        </a>

        <div class="flex items-center gap-3">
            <span class="hidden md:inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full border transition-all duration-200"
                  :class="scrolled ? 'text-emerald-700 bg-emerald-50 border-emerald-200' : 'text-emerald-100 bg-white/10 border-white/20'">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
                </span>
                Ruang Baca Gratis &amp; Ceria
            </span>
            @auth
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold text-white bg-brand-600 hover:bg-brand-700 shadow-md hover:shadow-lg hover:-translate-y-0.5 active:scale-95 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-brand-600 hover:bg-brand-700 shadow-md hover:shadow-lg hover:-translate-y-0.5 active:scale-95 transition-all duration-200">
                    Masuk ke Sistem
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            @endauth
        </div>
    </div>
</nav>

{{-- ═══════════════════════════════ 2. HERO SECTION ═══════════════════════════════ --}}
<section class="relative min-h-[92vh] flex items-center pt-24 pb-28 overflow-hidden"
         style="background: radial-gradient(140% 120% at 55% -5%, #022d10 0%, #054219 22%, #085a28 48%, #0b7233 70%, #12a24a 87%, #10b981 100%);">

    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-40 -left-40 w-[600px] h-[600px] rounded-full bg-emerald-400/10 blur-[80px]"></div>
        <div class="absolute top-1/3 -right-60 w-[700px] h-[700px] rounded-full bg-teal-300/10 blur-[100px]"></div>
        <div class="absolute inset-0 opacity-[0.07]" style="background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:32px 32px;"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
            
            {{-- Text Column --}}
            <div class="lg:col-span-7 text-center lg:text-left">
                <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md text-white text-xs sm:text-sm font-semibold mb-6 border border-white/20">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-300 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-400"></span>
                    </span>
                    Ruang Baca Gratis Anak Yayasan Peduli Anak
                </div>

                <h1 class="font-display text-4xl sm:text-6xl lg:text-7xl font-black text-white leading-[1.08] tracking-tight mb-6">
                    Selamat Datang di<br>
                    <span class="bg-gradient-to-r from-emerald-200 via-green-100 to-white bg-clip-text text-transparent">Perpustakaan YPA</span>
                </h1>

                <p class="text-base sm:text-lg text-emerald-50/90 max-w-2xl mx-auto lg:mx-0 leading-relaxed mb-8 font-medium">
                    Ruang baca gratis persembahan Yayasan Peduli Anak. Mari jelajahi ribuan cerita seru, tambah ilmu pengetahuan, dan jadikan membaca sebagai petualangan favoritmu setiap hari!
                </p>

                @guest
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                    <a href="{{ route('login') }}"
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-8 py-4 rounded-2xl bg-white text-brand-800 font-extrabold text-base shadow-2xl shadow-black/20 hover:shadow-black/30 hover:-translate-y-1 transition-all duration-200 active:scale-95 group">
                        <svg class="w-5 h-5 text-brand-600 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        Masuk ke Sistem Perpustakaan
                    </a>
                    <a href="{{ route('catalog') }}"
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-4 rounded-2xl text-white font-bold text-base border-2 border-white/30 bg-white/10 backdrop-blur-sm hover:bg-white/20 hover:-translate-y-0.5 transition-all duration-200">
                        Cari &amp; Jelajahi Buku
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
                @endguest
                @auth
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center justify-center gap-3 px-8 py-4 rounded-2xl bg-white text-brand-800 font-extrabold text-base shadow-2xl shadow-black/20 hover:-translate-y-1 transition-all duration-200 active:scale-95">
                    <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Buka Dashboard Perpustakaan
                </a>
                @endauth
            </div>

            {{-- Photo Showcase Hero Right --}}
            <div class="lg:col-span-5 relative mt-6 lg:mt-0">
                <div class="relative mx-auto max-w-md lg:max-w-none">
                    {{-- Main Photo 1 --}}
                    <div class="relative z-10 rounded-3xl overflow-hidden shadow-2xl border-4 border-white/20 transform -rotate-2 hover:rotate-0 transition-transform duration-300">
                        <img src="{{ asset('images/reading-library-1.jpg') }}"
                             alt="Kegiatan Membaca Perpustakaan YPA"
                             class="w-full h-64 sm:h-72 lg:h-80 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent flex items-end p-4">
                            <span class="text-xs font-bold text-white bg-black/40 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/20">
                                📖 Ruang Baca Nyaman &amp; Ceria
                            </span>
                        </div>
                    </div>

                    {{-- Secondary Photo 2 Overlapping --}}
                    <div class="absolute -bottom-8 -left-6 sm:-left-8 z-20 w-48 sm:w-56 rounded-2xl overflow-hidden shadow-2xl border-4 border-white/30 transform rotate-6 hover:rotate-0 transition-transform duration-300 hidden sm:block">
                        <img src="{{ asset('images/reading-library-2.jpg') }}"
                             alt="Anak-anak Membaca Buku YPA"
                             class="w-full h-36 sm:h-40 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent flex items-end p-2.5">
                            <span class="text-[10px] font-extrabold text-emerald-200 bg-emerald-950/60 backdrop-blur-md px-2 py-1 rounded-lg border border-emerald-400/30">
                                ✨ Generasi Literasi YPA
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="absolute bottom-0 left-0 right-0 pointer-events-none overflow-hidden leading-none">
        <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full" preserveAspectRatio="none" style="height:80px;display:block;">
            <path d="M0 80H1440V28C1300 58 1080 78 720 78C360 78 140 58 0 28V80Z" fill="#f8fafc"/>
        </svg>
    </div>
</section>

{{-- ═══════════════════════════════ 3. STATISTIK PERPUSTAKAAN ═══════════════════════════════ --}}
<section class="py-14 lg:py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-extrabold uppercase tracking-widest text-brand-600 bg-brand-50 px-3 py-1 rounded-full border border-brand-200/60">Aktivitas Membaca</span>
            <h2 class="font-display text-3xl sm:text-4xl font-black text-slate-900 mt-3 mb-2 tracking-tight">Statistik Perpustakaan</h2>
            <p class="text-slate-500 text-sm sm:text-base">Koleksi buku dan aktivitas membaca anak-anak di perpustakaan hari ini</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">

            {{-- 1. Total Buku --}}
            <div class="group bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-lg hover:border-emerald-400 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-emerald-50 text-emerald-600 border border-emerald-100 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <p class="text-3xl font-black text-slate-900 leading-tight tracking-tight stat-count" data-target="{{ $totalBooks }}">0</p>
                <p class="text-xs font-bold text-slate-500 mt-1">Total Koleksi Buku</p>
            </div>

            {{-- 2. Anggota Aktif --}}
            <div class="group bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-lg hover:border-blue-400 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-blue-50 text-blue-600 border border-blue-100 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <p class="text-3xl font-black text-slate-900 leading-tight tracking-tight stat-count" data-target="{{ $activeMembers }}">0</p>
                <p class="text-xs font-bold text-slate-500 mt-1">Teman Pembaca</p>
            </div>

            {{-- 3. Buku Dipinjam --}}
            <div class="group bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-lg hover:border-amber-400 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-amber-50 text-amber-600 border border-amber-100 group-hover:bg-amber-600 group-hover:text-white transition-all duration-300 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                </div>
                <p class="text-3xl font-black text-slate-900 leading-tight tracking-tight stat-count" data-target="{{ $activeLoans }}">0</p>
                <p class="text-xs font-bold text-slate-500 mt-1">Sedang Dibaca</p>
            </div>

            {{-- 4. Aktivitas Hari Ini --}}
            <div class="group bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-lg hover:border-purple-400 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-purple-50 text-purple-600 border border-purple-100 group-hover:bg-purple-600 group-hover:text-white transition-all duration-300 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
                <p class="text-3xl font-black text-slate-900 leading-tight tracking-tight stat-count" data-target="{{ $todayActivity }}">0</p>
                <p class="text-xs font-bold text-slate-500 mt-1">Aktivitas Hari Ini</p>
            </div>

            {{-- 5. Dikembalikan Hari Ini --}}
            <div class="group bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-lg hover:border-teal-400 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-teal-50 text-teal-600 border border-teal-100 group-hover:bg-teal-600 group-hover:text-white transition-all duration-300 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-3xl font-black text-slate-900 leading-tight tracking-tight stat-count" data-target="{{ $todayReturns }}">0</p>
                <p class="text-xs font-bold text-slate-500 mt-1">Dikembalikan Hari Ini</p>
            </div>

            {{-- 6. Peminjaman Baru Hari Ini --}}
            <div class="group bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-lg hover:border-indigo-400 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-indigo-50 text-indigo-600 border border-indigo-100 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                </div>
                <p class="text-3xl font-black text-slate-900 leading-tight tracking-tight stat-count" data-target="{{ $todayLoans }}">0</p>
                <p class="text-xs font-bold text-slate-500 mt-1">Buku Dipinjam Baru</p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════ 4. BUKU PALING POPULER ═══════════════════════════════ --}}
<section class="py-16 lg:py-24 bg-white border-t border-slate-200/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12 gap-4">
            <div>
                <span class="text-xs font-extrabold uppercase tracking-widest text-brand-600 bg-brand-50 px-3 py-1 rounded-full border border-brand-200/60">
                    Buku Favorit
                </span>
                <h2 class="font-display text-3xl sm:text-4xl font-black text-slate-900 mt-3 tracking-tight">
                    📚 Buku Paling Sering Dibaca
                </h2>
                <p class="text-slate-500 text-sm sm:text-base mt-1">
                    Pilihan cerita dan buku favorit yang paling sering dipinjam oleh teman-teman
                </p>
            </div>
            <a href="{{ route('catalog') }}"
               class="self-start sm:self-auto inline-flex items-center gap-2 text-sm font-bold text-brand-600 hover:text-brand-800 hover:underline transition-colors">
                Lihat Semua Katalog Buku
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        @if($popularBooks->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">
                @foreach($popularBooks as $index => $book)
                    @php
                        $rank = $index + 1;
                        $categoryCode = $book->category->code ?? '';
                        $gradientClass = match($categoryCode) {
                            'TECH' => 'from-slate-800 via-indigo-950 to-slate-900',
                            'FIC'  => 'from-emerald-900 via-teal-950 to-slate-900',
                            'SCI'  => 'from-blue-900 via-cyan-950 to-slate-900',
                            'HIST' => 'from-amber-900 via-stone-900 to-slate-950',
                            'BUS'  => 'from-slate-800 via-emerald-950 to-slate-950',
                            'SELF' => 'from-purple-900 via-slate-900 to-indigo-950',
                            default => 'from-slate-800 via-slate-900 to-emerald-950',
                        };
                    @endphp

                    <div class="group bg-white rounded-2xl border border-slate-200/90 p-4 sm:p-5 hover:border-emerald-400 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex gap-4 sm:gap-5 items-start relative overflow-hidden">

                        {{-- COVER THUMBNAIL --}}
                        <div class="w-24 sm:w-28 flex-shrink-0 aspect-[3/4] rounded-xl overflow-hidden shadow-md relative group-hover:shadow-lg transition-shadow bg-slate-900">
                            @if(!empty($book->cover_thumbnail))
                                <img src="{{ asset('storage/' . $book->cover_thumbnail) }}"
                                     alt="{{ $book->title }}"
                                     loading="lazy"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @elseif(!empty($book->cover_image))
                                <img src="{{ asset('storage/' . $book->cover_image) }}"
                                     alt="{{ $book->title }}"
                                     loading="lazy"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-gradient-to-br {{ $gradientClass }} p-3 flex flex-col justify-between relative border-l-4 border-white/20">
                                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 8px 8px;"></div>
                                    <span class="relative z-10 inline-block text-[7px] font-extrabold tracking-wider uppercase bg-white/15 text-emerald-200 px-1.5 py-0.5 rounded border border-white/10 truncate max-w-full">
                                        {{ $book->category->name ?? 'Buku' }}
                                    </span>
                                    <div class="relative z-10 text-center">
                                        <svg class="w-7 h-7 mx-auto text-emerald-300/80 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                        <p class="text-white font-extrabold text-[9px] line-clamp-3 leading-tight">{{ $book->title }}</p>
                                    </div>
                                    <p class="relative z-10 text-[8px] text-emerald-300/70 truncate">{{ $book->author }}</p>
                                </div>
                            @endif
                        </div>

                        {{-- DETAILS --}}
                        <div class="flex-1 min-w-0 flex flex-col justify-between self-stretch">
                            <div>
                                <div class="flex items-center justify-between gap-2 mb-1.5">
                                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200/60">
                                        {{ $book->category->name ?? 'Umum' }}
                                    </span>

                                    {{-- Rank Badge --}}
                                    @if($rank === 1)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-black bg-gradient-to-r from-amber-400 to-amber-500 text-amber-950 shadow-sm border border-amber-300">
                                            🥇 #1
                                        </span>
                                    @elseif($rank === 2)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-black bg-gradient-to-r from-slate-200 to-slate-300 text-slate-700 shadow-sm border border-slate-300">
                                            🥈 #2
                                        </span>
                                    @elseif($rank === 3)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-black bg-gradient-to-r from-amber-700/20 to-amber-800/30 text-amber-900 border border-amber-700/30">
                                            🥉 #3
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-slate-100 text-slate-500 border border-slate-200">
                                            #{{ $rank }}
                                        </span>
                                    @endif
                                </div>

                                <h3 class="font-extrabold text-slate-900 text-sm sm:text-base leading-snug line-clamp-2 mb-1 group-hover:text-emerald-700 transition-colors">
                                    {{ $book->title }}
                                </h3>

                                <p class="text-xs text-slate-400 font-medium mb-2.5 truncate">
                                    Penulis: <span class="text-slate-600 font-semibold">{{ $book->author }}</span>
                                </p>

                                @if($book->genres->isNotEmpty())
                                    <div class="flex flex-wrap gap-1 mb-3">
                                        @foreach($book->genres->take(3) as $g)
                                            <span class="text-[10px] font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded-md border border-slate-200/70">
                                                {{ $g->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <div class="pt-2.5 border-t border-slate-100 flex items-center justify-between mt-auto">
                                <div class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200/60">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <span>{{ $book->loans_count }}x Dibaca</span>
                                </div>
                                <span class="text-[11px] font-semibold text-slate-400">
                                    Tersedia: {{ $book->available_copies }}/{{ $book->total_copies }} buku
                                </span>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                <p class="text-sm font-semibold text-slate-500">Belum ada riwayat buku yang dipinjam.</p>
            </div>
        @endif

    </div>
</section>

{{-- ═══════════════════════════════ 5. SUASANA & KENAPA MEMILIH YPA ═══════════════════════════════ --}}
<section class="py-16 lg:py-24 bg-slate-50 border-t border-slate-200/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Feature Cards + Gallery Row --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            {{-- Gallery photos --}}
            <div class="lg:col-span-6 order-2 lg:order-1">
                <div class="grid grid-cols-2 gap-4">
                    <div class="rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-shadow border-2 border-white">
                        <img src="{{ asset('images/reading-library-1.jpg') }}" alt="Suasana Membaca YPA" class="w-full h-56 sm:h-64 object-cover hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-shadow border-2 border-white mt-6">
                        <img src="{{ asset('images/reading-library-2.jpg') }}" alt="Aktivitas Membaca Anak" class="w-full h-56 sm:h-64 object-cover hover:scale-105 transition-transform duration-300">
                    </div>
                </div>
            </div>

            {{-- Text / Section info --}}
            <div class="lg:col-span-6 order-1 lg:order-2">
                <span class="text-xs font-extrabold uppercase tracking-widest text-brand-600 bg-brand-50 px-3 py-1 rounded-full border border-brand-200/60">
                    Suasana &amp; Fasilitas
                </span>
                <h2 class="font-display text-3xl sm:text-4xl font-black text-slate-900 mt-3 mb-4 tracking-tight">
                    Mengapa Asyik Membaca di Perpustakaan YPA?
                </h2>
                <p class="text-slate-600 text-base leading-relaxed mb-6">
                    Perpustakaan Yayasan Peduli Anak hadir sebagai tempat yang hangat, tenang, dan penuh petualangan cerita. Di sini, semua anak didik yayasan bisa bebas membaca dan meminjam buku favorit secara gratis!
                </p>

                <div class="space-y-4">
                    <div class="flex gap-4 p-4 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 font-bold text-lg">📚</div>
                        <div>
                            <h4 class="font-extrabold text-slate-900 text-sm">Koleksi Cerita &amp; Ilmu Lengkap</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Ribuan komik, cerita dongeng, pengetahuran umum, dan buku pelajaran yang seru untuk dibaca.</p>
                        </div>
                    </div>

                    <div class="flex gap-4 p-4 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 font-bold text-lg">🏡</div>
                        <div>
                            <h4 class="font-extrabold text-slate-900 text-sm">Tempat Nyaman &amp; Ceria</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Ruang baca yang tenang dan aman untuk membaca sendiri atau belajar bersama teman-teman.</p>
                        </div>
                    </div>

                    <div class="flex gap-4 p-4 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center flex-shrink-0 font-bold text-lg">⚡</div>
                        <div>
                            <h4 class="font-extrabold text-slate-900 text-sm">Pinjam Buku 100% Gratis</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Bebas pilih buku apa saja dan bawa pulang untuk dibaca di mana saja tanpa biaya.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- ═══════════════════════════════ 6. TESTIMONI PEMBACA ═══════════════════════════════ --}}
@if($publicReviews->isNotEmpty())
<section class="py-16 lg:py-20 bg-white border-t border-slate-200/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-extrabold uppercase tracking-widest text-brand-600 bg-brand-50 px-3 py-1 rounded-full border border-brand-200/60">Kesan Pembaca</span>
            <h2 class="font-display text-3xl sm:text-4xl font-black text-slate-900 mt-3 mb-2 tracking-tight">Apa Kata Teman-Teman Pembaca</h2>
            <p class="text-slate-500 text-sm sm:text-base">Pengalaman seru membaca buku di perpustakaan YPA</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($publicReviews as $i => $review)
            <div class="group bg-slate-50 rounded-2xl p-6 border border-slate-200/80 hover:shadow-lg hover:border-emerald-300 hover:-translate-y-1 transition-all duration-300 relative">
                <p class="text-slate-700 text-sm leading-relaxed italic mb-5 pr-8">
                    "{{ Str::limit($review->comment, 160) }}"
                </p>

                <div class="flex items-center gap-3 border-t border-slate-200/80 pt-4">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-emerald-400 to-teal-600 flex items-center justify-center text-white font-black text-sm flex-shrink-0">
                        {{ Str::upper(Str::substr($review->member->member_type ?? 'A', 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-slate-700">
                            Teman Pembaca
                            @if($review->member->grade)
                                <span class="font-normal text-slate-400">· Kelas {{ $review->member->grade }}</span>
                            @endif
                        </p>
                        @if($review->book)
                        <p class="text-[10px] text-emerald-700 font-semibold truncate">
                            📖 {{ Str::limit($review->book->title, 40) }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════════ 7. CTA PENUTUP ═══════════════════════════════ --}}
<section class="py-20 lg:py-28 relative overflow-hidden border-t border-slate-200/60"
         style="background: linear-gradient(135deg, #022d10 0%, #054219 30%, #085a28 55%, #0b7233 80%, #12a24a 100%);">

    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute inset-0 opacity-[0.06]" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 24px 24px;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] rounded-full bg-emerald-400/20 blur-[100px]"></div>
    </div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-flex items-center gap-2 text-xs font-extrabold uppercase tracking-widest text-emerald-300 bg-white/10 px-3 py-1 rounded-full border border-white/20 mb-6">
            Ayo Membaca!
        </span>

        <h2 class="font-display text-4xl sm:text-5xl lg:text-6xl font-black text-white mb-6 tracking-tight leading-tight">
            Yuk, Temukan Buku<br>
            <span class="text-emerald-200">Favoritmu Hari Ini!</span>
        </h2>
        <p class="text-emerald-100/85 text-base sm:text-lg mb-10 max-w-2xl mx-auto leading-relaxed">
            Pintu perpustakaan selalu terbuka lebar untukmu. Ambil bukumu, duduk dengan nyaman, dan mulailah petualangan membaca gratis sekarang!
        </p>

        @guest
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('login') }}"
               class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-8 py-4 rounded-2xl bg-white text-brand-800 font-extrabold text-base shadow-2xl shadow-black/30 hover:shadow-black/40 hover:-translate-y-1 transition-all duration-200 active:scale-95 group">
                <svg class="w-5 h-5 text-brand-600 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                Masuk ke Sistem Perpustakaan
            </a>
        </div>
        @endguest
        @auth
        <a href="{{ route('dashboard') }}"
           class="inline-flex items-center gap-3 px-8 py-4 rounded-2xl bg-white text-brand-800 font-extrabold text-base shadow-2xl hover:-translate-y-1 transition-all duration-200 active:scale-95">
            Buka Dashboard
            <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
        @endauth
    </div>
</section>

{{-- ═══════════════════════════════ 8. FOOTER ═══════════════════════════════ --}}
<footer class="bg-slate-950 border-t border-slate-800/80 pt-14 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 pb-10 border-b border-slate-800/60">

            <div class="lg:col-span-2">
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('images/logoypa.png') }}" alt="Logo YPA" class="h-10 w-10 rounded-xl object-contain bg-white p-0.5 shadow-sm">
                    <div>
                        <p class="font-black text-base text-white leading-none">Perpustakaan YPA</p>
                        <p class="text-xs font-semibold text-slate-400 mt-1">Yayasan Peduli Anak</p>
                    </div>
                </div>
                <p class="text-sm text-slate-400 leading-relaxed max-w-sm">
                    Perpustakaan Yayasan Peduli Anak adalah fasilitas membaca gratis yang dipersembahkan untuk mendukung tumbuh kembang, minat baca, dan keceriaan anak didik yayasan.
                </p>
            </div>

            <div>
                <h4 class="text-sm font-extrabold text-white uppercase tracking-wider mb-4">Navigasi</h4>
                <ul class="space-y-2.5">
                    <li><a href="{{ route('landing') }}" class="text-sm text-slate-400 hover:text-white transition-colors">Beranda</a></li>
                    <li><a href="{{ route('catalog') }}" class="text-sm text-slate-400 hover:text-white transition-colors">Katalog Buku</a></li>
                    <li><a href="{{ route('login') }}" class="text-sm text-slate-400 hover:text-white transition-colors">Masuk ke Sistem</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-extrabold text-white uppercase tracking-wider mb-4">Informasi</h4>
                <ul class="space-y-2.5">
                    <li class="text-sm text-slate-400">Yayasan Peduli Anak</li>
                    <li class="text-sm text-slate-400">Senin – Sabtu, 07.00 – 17.00</li>
                    <li class="text-sm text-slate-400">perpustakaan@ypa.sch.id</li>
                </ul>
            </div>
        </div>

        <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-xs font-medium text-slate-500">
                &copy; {{ date('Y') }} Perpustakaan YPA &mdash; Yayasan Peduli Anak. Semua hak dilindungi.
            </p>
            <p class="text-xs text-slate-600">
                Dibangun dengan <span class="text-emerald-500">♥</span> untuk anak-anak Indonesia
            </p>
        </div>
    </div>
</footer>

</div>