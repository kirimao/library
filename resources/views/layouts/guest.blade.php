<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Perpustakaan YPA') }} — Masuk ke Sistem</title>

        <link rel="icon" type="image/png" href="{{ asset('images/logoypa.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,700;12..96,800;12..96,900&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .font-display { font-family: 'Bricolage Grotesque', 'Inter', sans-serif; }
            .text-shadow-md { text-shadow: 0 2px 8px rgba(0, 0, 0, 0.6); }
        </style>
    </head>
    <body class="h-full font-sans antialiased text-slate-800 bg-slate-900 overflow-hidden">

        {{-- 50/50 Fixed 100vh Viewport Layout (No Scrollbars) --}}
        <div class="h-screen w-full flex flex-col lg:flex-row overflow-hidden">
            
            {{-- Left Side: 50% Visual Panel with Brighter Photo & Branding --}}
            <div class="relative lg:w-1/2 w-full h-full flex flex-col justify-between p-6 sm:p-8 lg:p-10 overflow-hidden bg-emerald-950 flex-shrink-0">
                
                {{-- Brighter Background Photo with Subtle Overlay --}}
                <div class="absolute inset-0 z-0">
                    <img src="{{ asset('images/reading-library-1.jpg') }}" alt="Suasana Perpustakaan YPA" class="w-full h-full object-cover opacity-75 filter contrast-105">
                    {{-- Soft Overlay for text readability --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/90 via-emerald-950/45 to-emerald-900/30"></div>
                </div>

                {{-- Header & Logo --}}
                <div class="relative z-10 flex items-center justify-between">
                    <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                        <img src="{{ asset('images/logoypa.png') }}" alt="Logo YPA" class="h-10 w-10 rounded-2xl bg-white p-1 border border-white/30 shadow-lg group-hover:scale-105 transition-transform duration-200">
                        <div>
                            <p class="font-black text-white text-base leading-tight tracking-tight text-shadow-md">Perpustakaan YPA</p>
                            <p class="text-[11px] text-emerald-100 font-semibold mt-0.5 text-shadow-md">Yayasan Peduli Anak</p>
                        </div>
                    </a>

                    <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 text-xs font-extrabold text-white bg-slate-900/60 hover:bg-slate-900/80 backdrop-blur-md px-3.5 py-1.5 rounded-full border border-white/25 shadow-md transition-all duration-200 hover:-translate-y-0.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Ke Beranda
                    </a>
                </div>

                {{-- Hero Copy / Content --}}
                <div class="relative z-10 my-auto py-4 max-w-xl">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-slate-900/60 backdrop-blur-md text-emerald-200 text-xs font-extrabold border border-white/20 mb-4 shadow-md">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Sistem Informasi Perpustakaan YPA
                    </div>

                    <h1 class="font-display text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-[1.12] tracking-tight mb-4 text-shadow-md">
                        Ruang Baca Gratis,<br>
                        <span class="text-emerald-300">Ceria Setiap Hari.</span>
                    </h1>

                    <p class="text-emerald-50 text-sm sm:text-base leading-relaxed font-medium mb-6 text-shadow-md">
                        Fasilitas membaca gratis persembahan Yayasan Peduli Anak untuk mendukung minat baca, pengetahuan, dan cita-cita seluruh anak didik yayasan.
                    </p>

                    {{-- Featured Photo Thumbnail Badge --}}
                    <div class="flex items-center gap-3.5 p-3 rounded-2xl bg-slate-900/60 backdrop-blur-md border border-white/20 max-w-md shadow-lg">
                        <img src="{{ asset('images/reading-library-2.jpg') }}" alt="Anak-anak membaca" class="w-12 h-12 rounded-xl object-cover border border-white/40 shadow-md flex-shrink-0">
                        <div>
                            <p class="text-xs font-black text-white">Kegiatan Membaca Bersama</p>
                            <p class="text-[11px] text-emerald-200 font-medium mt-0.5">Ribuan koleksi buku cerita &amp; ilmu pengetahuan tersedia gratis.</p>
                        </div>
                    </div>
                </div>

                {{-- Footer Text --}}
                <div class="relative z-10 text-[11px] text-emerald-100 font-semibold tracking-wide text-shadow-md">
                    &copy; {{ date('Y') }} Perpustakaan YPA &mdash; Yayasan Peduli Anak. All rights reserved.
                </div>

            </div>

            {{-- Right Side: 50% Spacious Form Container --}}
            <div class="relative lg:w-1/2 w-full h-full bg-slate-50 flex items-center justify-center p-6 sm:p-8 lg:p-10 overflow-y-auto lg:overflow-hidden">
                
                {{-- Form Outer Wrapper: Compact & Roomy --}}
                <div class="w-full max-w-md my-auto">
                    <div class="bg-white rounded-3xl p-6 sm:p-9 shadow-2xl border border-slate-200/90">
                        {{ $slot }}
                    </div>
                </div>

            </div>

        </div>

    </body>
</html>
