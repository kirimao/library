<div class="min-h-screen bg-slate-50 text-slate-800 font-sans selection:bg-brand-500 selection:text-white">

    {{-- NAVBAR --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-200/80 shadow-sm transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('images/logoypa.png') }}" alt="Logo YPA"
                     class="h-9 w-9 rounded-xl object-contain bg-white p-0.5 border border-slate-200 shadow-sm group-hover:scale-105 transition-transform duration-200">
                <div>
                    <p class="font-black text-sm text-slate-900 leading-none group-hover:text-brand-600 transition-colors">Perpustakaan YPA</p>
                    <p class="text-[10px] font-semibold text-slate-400 mt-0.5">Yayasan Peduli Anak</p>
                </div>
            </a>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold text-white transition-all shadow-md shadow-brand-500/20 hover:shadow-lg hover:shadow-brand-500/30 hover:-translate-y-0.5 active:scale-95"
                       style="background-color: #12a24a;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white transition-all shadow-md shadow-brand-500/20 hover:shadow-lg hover:shadow-brand-500/30 hover:-translate-y-0.5 active:scale-95"
                       style="background-color: #12a24a;">
                        <span>Masuk ke Sistem</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- HERO SECTION --}}
    <section class="relative pt-24 pb-20 lg:pt-32 lg:pb-28 overflow-hidden"
             style="background: radial-gradient(130% 100% at 50% 0%, #085a28 0%, #0b7233 45%, #12a24a 80%, #10b981 100%);">

        {{-- Decorative Background Elements --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-20">
            <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-white blur-3xl"></div>
            <div class="absolute top-1/2 -right-24 w-96 h-96 rounded-full bg-emerald-300 blur-3xl"></div>
            <div class="absolute bottom-0 left-1/3 w-64 h-64 rounded-full bg-green-200 blur-2xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto">
                
                {{-- Live Badge --}}
                <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md text-white text-xs sm:text-sm font-semibold mb-8 border border-white/20 shadow-inner">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-300 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-400"></span>
                    </span>
                    <span>Perpustakaan Aktif & Terbuka Setiap Hari</span>
                </div>

                {{-- Prominent Title --}}
                <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black text-white leading-[1.1] tracking-tight mb-6 text-shadow-sm">
                    Selamat Datang di<br>
                    <span class="bg-gradient-to-r from-emerald-200 via-green-100 to-white bg-clip-text text-transparent drop-shadow-sm">
                        Perpustakaan YPA
                    </span>
                </h1>

                {{-- Subtitle --}}
                <p class="text-base sm:text-xl text-emerald-50/90 max-w-2xl mx-auto leading-relaxed mb-10 font-medium">
                    Yayasan Peduli Anak — Tempat di mana buku membuka jendela dunia bagi anak-anak.
                    Temukan koleksi buku pilihan kami dan tumbuhkan semangat membaca sejak dini.
                </p>

                {{-- CTA Button --}}
                @guest
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('login') }}"
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-8 py-4 rounded-2xl bg-white text-brand-800 hover:text-brand-900 font-extrabold text-base shadow-xl shadow-black/15 hover:shadow-2xl hover:shadow-black/25 hover:-translate-y-1 transition-all duration-200 active:scale-95 group">
                        <svg class="w-5 h-5 text-brand-600 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        <span>Masuk ke Sistem Perpustakaan</span>
                    </a>
                </div>
                @endguest
            </div>
        </div>

        {{-- Curved Bottom Divider --}}
        <div class="absolute bottom-0 left-0 right-0 h-10 sm:h-14 overflow-hidden pointer-events-none">
            <svg viewBox="0 0 1440 54" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full preserve-3d" preserveAspectRatio="none">
                <path d="M0 54H1440V12C1200 40 960 54 720 54C480 54 240 40 0 12V54Z" fill="#F8FAFC"/>
            </svg>
        </div>
    </section>

    {{-- STATISTICS SECTION --}}
    <section class="py-12 lg:py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="text-xs font-extrabold uppercase tracking-widest text-brand-600 bg-brand-50 px-3 py-1 rounded-full border border-brand-200/60">
                    Dashboard Ringkasan
                </span>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 mt-2 mb-1.5 tracking-tight">
                    Statistik Perpustakaan
                </h2>
                <p class="text-slate-500 text-sm sm:text-base">
                    Data real-time kondisi koleksi, keanggotaan, dan aktivitas perpustakaan hari ini
                </p>
            </div>

            {{-- 6 UNIFIED COMPACT STAT CARDS GRID --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3.5 sm:gap-4">
                
                {{-- 1. Total Koleksi Buku --}}
                <div class="group bg-white rounded-2xl p-4 border border-slate-200/80 shadow-sm hover:shadow-lg hover:border-emerald-400 hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-3.5 h-full">
                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl flex items-center justify-center bg-emerald-50 text-emerald-600 border border-emerald-100/80 group-hover:scale-105 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300 flex-shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-2xl sm:text-3xl font-black text-slate-900 leading-tight tracking-tight">{{ number_format($totalBooks) }}</p>
                        <p class="text-xs font-bold text-slate-500 truncate mt-0.5">Total Buku</p>
                    </div>
                </div>

                {{-- 2. Anggota Aktif --}}
                <div class="group bg-white rounded-2xl p-4 border border-slate-200/80 shadow-sm hover:shadow-lg hover:border-blue-400 hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-3.5 h-full">
                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl flex items-center justify-center bg-blue-50 text-blue-600 border border-blue-100/80 group-hover:scale-105 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 flex-shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-2xl sm:text-3xl font-black text-slate-900 leading-tight tracking-tight">{{ number_format($activeMembers) }}</p>
                        <p class="text-xs font-bold text-slate-500 truncate mt-0.5">Anggota Aktif</p>
                    </div>
                </div>

                {{-- 3. Buku Sedang Dipinjam --}}
                <div class="group bg-white rounded-2xl p-4 border border-slate-200/80 shadow-sm hover:shadow-lg hover:border-amber-400 hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-3.5 h-full">
                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl flex items-center justify-center bg-amber-50 text-amber-600 border border-amber-100/80 group-hover:scale-105 group-hover:bg-amber-600 group-hover:text-white transition-all duration-300 flex-shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-2xl sm:text-3xl font-black text-slate-900 leading-tight tracking-tight">{{ number_format($activeLoans) }}</p>
                        <p class="text-xs font-bold text-slate-500 truncate mt-0.5">Dipinjam</p>
                    </div>
                </div>

                {{-- 4. Aktivitas Hari Ini --}}
                <div class="group bg-white rounded-2xl p-4 border border-slate-200/80 shadow-sm hover:shadow-lg hover:border-purple-400 hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-3.5 h-full">
                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl flex items-center justify-center bg-purple-50 text-purple-600 border border-purple-100/80 group-hover:scale-105 group-hover:bg-purple-600 group-hover:text-white transition-all duration-300 flex-shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-2xl sm:text-3xl font-black text-slate-900 leading-tight tracking-tight">{{ number_format($todayActivity) }}</p>
                        <p class="text-xs font-bold text-slate-500 truncate mt-0.5">Aktivitas Hari Ini</p>
                    </div>
                </div>

                {{-- 5. Pengembalian Hari Ini --}}
                <div class="group bg-white rounded-2xl p-4 border border-slate-200/80 shadow-sm hover:shadow-lg hover:border-teal-400 hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-3.5 h-full">
                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl flex items-center justify-center bg-teal-50 text-teal-600 border border-teal-100/80 group-hover:scale-105 group-hover:bg-teal-600 group-hover:text-white transition-all duration-300 flex-shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-2xl sm:text-3xl font-black text-slate-900 leading-tight tracking-tight">{{ number_format($todayReturns) }}</p>
                        <p class="text-xs font-bold text-slate-500 truncate mt-0.5">Kembali Hari Ini</p>
                    </div>
                </div>

                {{-- 6. Peminjaman Baru Hari Ini --}}
                <div class="group bg-white rounded-2xl p-4 border border-slate-200/80 shadow-sm hover:shadow-lg hover:border-indigo-400 hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-3.5 h-full">
                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl flex items-center justify-center bg-indigo-50 text-indigo-600 border border-indigo-100/80 group-hover:scale-105 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300 flex-shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-2xl sm:text-3xl font-black text-slate-900 leading-tight tracking-tight">{{ number_format($todayLoans) }}</p>
                        <p class="text-xs font-bold text-slate-500 truncate mt-0.5">Pinjaman Baru</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- POPULAR BOOKS SECTION --}}
    <section class="py-16 lg:py-24 bg-white border-t border-slate-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12 gap-4">
                <div>
                    <span class="text-xs font-extrabold uppercase tracking-widest text-brand-600 bg-brand-50 px-3 py-1 rounded-full border border-brand-200/60">
                        Koleksi Favorit
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-black text-slate-900 mt-3 tracking-tight flex items-center gap-3">
                        <span>📚 Buku Paling Populer</span>
                    </h2>
                    <p class="text-slate-500 text-sm sm:text-base mt-1">
                        Ranking buku yang paling sering dipinjam dan dibaca oleh anggota perpustakaan
                    </p>
                </div>
            </div>

            @if($popularBooks->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">
                    @foreach($popularBooks as $index => $book)
                        @php
                            $rank = $index + 1;
                            
                            // Visual theme gradient fallback mapping based on category code
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
                            
                            {{-- BOOK COVER THUMBNAIL (LEFT SIDE) --}}
                            <div class="w-24 sm:w-28 flex-shrink-0 aspect-[3/4] rounded-xl overflow-hidden shadow-md relative group-hover:shadow-lg transition-shadow bg-slate-900">
                                @if(!empty($book->cover_image) || !empty($book->cover))
                                    <img src="{{ asset('storage/' . ($book->cover_image ?? $book->cover)) }}"
                                         alt="{{ $book->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    {{-- Stylized Graphic Book Cover Placeholder --}}
                                    <div class="w-full h-full bg-gradient-to-br {{ $gradientClass }} p-2.5 flex flex-col justify-between relative border-l-4 border-white/20">
                                        {{-- Pattern overlay --}}
                                        <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:8px_8px]"></div>
                                        <div class="absolute -right-6 -bottom-6 w-16 h-16 rounded-full bg-emerald-500/20 blur-md"></div>
                                        
                                        <div class="relative z-10">
                                            <span class="inline-block text-[8px] font-extrabold tracking-wider uppercase bg-white/15 backdrop-blur-md text-emerald-200 px-1.5 py-0.5 rounded border border-white/10 truncate max-w-full">
                                                {{ $book->category->name ?? 'Buku' }}
                                            </span>
                                        </div>

                                        <div class="relative z-10 my-auto text-center py-1">
                                            <svg class="w-7 h-7 mx-auto text-emerald-300/80 mb-1 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                        </div>

                                        <div class="relative z-10">
                                            <p class="text-white font-extrabold text-[10px] sm:text-[11px] line-clamp-2 leading-tight group-hover:text-emerald-300 transition-colors">
                                                {{ $book->title }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- BOOK DETAILS & CONTENT (RIGHT SIDE) --}}
                            <div class="flex-1 min-w-0 flex flex-col justify-between self-stretch">
                                <div>
                                    {{-- TOP ROW: CATEGORY BADGE & RANKING BADGE --}}
                                    <div class="flex items-center justify-between gap-2 mb-1.5">
                                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200/60">
                                            {{ $book->category->name ?? 'Buku' }}
                                        </span>

                                        {{-- RANKING BADGE --}}
                                        <div>
                                            @if($rank === 1)
                                                <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-black bg-gradient-to-r from-amber-400 to-amber-500 text-amber-950 shadow-sm border border-amber-300 ring-2 ring-amber-300/40">
                                                    🥇 #1
                                                </span>
                                            @elseif($rank === 2)
                                                <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-black bg-gradient-to-r from-slate-200 to-slate-300 text-slate-800 shadow-sm border border-slate-300 ring-2 ring-slate-200/50">
                                                    🥈 #2
                                                </span>
                                            @elseif($rank === 3)
                                                <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-black bg-gradient-to-r from-amber-700/20 to-amber-800/30 text-amber-900 border border-amber-700/30 ring-2 ring-amber-700/10">
                                                    🥉 #3
                                                </span>
                                            @else
                                                <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-slate-100 text-slate-600 border border-slate-200 group-hover:bg-emerald-50 group-hover:text-emerald-700 group-hover:border-emerald-200 transition-colors">
                                                    #{{ $rank }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- TITLE --}}
                                    <h3 class="font-extrabold text-slate-900 text-sm sm:text-base leading-snug line-clamp-2 mb-1 group-hover:text-emerald-600 transition-colors">
                                        {{ $book->title }}
                                    </h3>

                                    {{-- AUTHOR --}}
                                    <p class="text-xs text-slate-400 font-medium mb-2.5 truncate">
                                        Oleh: <span class="text-slate-600 font-semibold">{{ $book->author }}</span>
                                    </p>

                                    {{-- GENRE TAGS --}}
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

                                {{-- FOOTER: STAT & STOCK --}}
                                <div class="pt-2.5 border-t border-slate-100 flex items-center justify-between mt-auto">
                                    <div class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200/60">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                        <span>{{ $book->loans_count }}x Dibaca</span>
                                    </div>
                                    <span class="text-[11px] font-semibold text-slate-400">
                                        Stok: {{ $book->available_copies }}/{{ $book->total_copies }}
                                    </span>
                                </div>

                            </div>

                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                    <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <p class="text-sm font-semibold text-slate-500">Belum ada riwayat pembacaan buku.</p>
                </div>
            @endif

        </div>
    </section>

    {{-- CTA SECTION --}}
    <section class="py-20 lg:py-24 relative overflow-hidden"
             style="background: linear-gradient(135deg, #054219 0%, #0b7233 60%, #12a24a 100%);">
        
        {{-- Background Glow --}}
        <div class="absolute inset-0 pointer-events-none opacity-20">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full bg-emerald-400 blur-3xl"></div>
        </div>

        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl sm:text-5xl font-black text-white mb-6 tracking-tight">
                Bergabunglah Bersama Kami
            </h2>
            <p class="text-emerald-100/90 text-base sm:text-lg mb-10 max-w-2xl mx-auto leading-relaxed font-medium">
                Daftarkan anak-anak Anda sebagai anggota perpustakaan dan nikmati ribuan koleksi buku pilihan untuk menumbuhkan kecintaan membaca sejak dini.
            </p>
            @guest
            <a href="{{ route('login') }}"
               class="inline-flex items-center gap-3 px-8 py-4 rounded-2xl bg-white text-brand-800 hover:text-brand-900 font-extrabold text-base shadow-2xl hover:-translate-y-1 transition-all duration-200 active:scale-95 group">
                <span>Masuk ke Sistem Perpustakaan</span>
                <svg class="w-5 h-5 text-brand-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
            @endguest
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-slate-950 border-t border-slate-800/80 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logoypa.png') }}" alt="Logo YPA"
                         class="h-9 w-9 rounded-xl object-contain bg-white p-0.5 shadow-sm">
                    <div>
                        <p class="font-extrabold text-sm text-white leading-none">Perpustakaan YPA</p>
                        <p class="text-[10px] font-semibold text-slate-400 mt-1">Yayasan Peduli Anak</p>
                    </div>
                </div>
                <div class="text-center sm:text-right">
                    <p class="text-xs font-medium text-slate-400">
                        &copy; {{ date('Y') }} Perpustakaan YPA. Semua hak dilindungi.
                    </p>
                </div>
            </div>
        </div>
    </footer>

</div>
