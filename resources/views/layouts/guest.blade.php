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
            .font-display { font-family: 'Keep Calm', 'KeepCalm', 'Inter', sans-serif; }
            .text-shadow-md { text-shadow: 0 2px 10px rgba(0, 0, 0, 0.7); }
            .text-shadow-lg { text-shadow: 0 4px 20px rgba(0, 0, 0, 0.8); }
        </style>
    </head>
    <body class="min-h-screen font-sans antialiased text-slate-800 bg-emerald-950 relative overflow-x-hidden">

        {{-- Full Screen Background Image with Multi-layer Rich Gradient Overlay --}}
        <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
            <img src="{{ asset('images/reading-library-1.jpg') }}" alt="Suasana Perpustakaan YPA" class="w-full h-full object-cover opacity-95 filter brightness-105 contrast-105 scale-105">
            {{-- Lighter emerald dark gradient overlay so children in photo are clearly visible --}}
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-950/70 via-emerald-950/50 to-slate-950/65"></div>
            {{-- Radial subtle glow accent --}}
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_25%_25%,rgba(16,185,129,0.15),transparent_60%)]"></div>
        </div>

        {{-- Foreground Wrapper --}}
        <div class="relative z-10 min-h-screen flex flex-col justify-between p-5 sm:p-8 lg:p-10 container mx-auto max-w-7xl">
            
            {{-- Top Header Navigation --}}
            <header class="flex items-center justify-between gap-4">
                <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                    <div class="h-11 w-11 rounded-2xl bg-white/95 p-1.5 border border-white/40 shadow-xl backdrop-blur-md flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                        <img src="{{ asset('images/logoypa.png') }}" alt="Logo YPA" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <p class="font-black text-white text-base leading-tight tracking-tight text-shadow-md">{{ __('landing.hero_library_name') }}</p>
                        <p class="text-[11px] text-emerald-200 font-semibold mt-0.5 text-shadow-md">{{ __('landing.foundation_name') }}</p>
                    </div>
                </a>

                <div class="flex items-center gap-3">
                    <livewire:language-switcher />
                    <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 text-xs font-extrabold text-white bg-slate-900/60 hover:bg-slate-900/80 backdrop-blur-md px-4 py-2 rounded-full border border-white/25 shadow-md transition-all duration-200 hover:-translate-y-0.5">
                        <img src="{{ asset('Visual Asset Icon/Visual Icon Asset_g44.png') }}" class="w-4 h-4 object-contain" alt="Home Icon">
                        {{ __('landing.footer_home') }}
                    </a>
                </div>
            </header>

            {{-- Middle Main Grid Content --}}
            <main class="my-auto py-8 sm:py-12 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                
                {{-- Left Branding & Hero Copy --}}
                <div class="lg:col-span-6 xl:col-span-7 max-w-xl">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-500/20 backdrop-blur-md text-emerald-200 text-xs font-extrabold border border-emerald-400/30 mb-5 shadow-lg">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        {{ __('landing.hero_library_name') }}
                    </div>

                    <h1 class="font-display text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-[1.12] tracking-tight mb-4 text-shadow-lg">
                        Ruang Baca Gratis,<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 via-teal-200 to-emerald-400">Ceria Setiap Hari.</span>
                    </h1>

                    <p class="text-emerald-50/90 text-sm sm:text-base leading-relaxed font-medium mb-8 text-shadow-md">
                        Fasilitas membaca gratis persembahan {{ __('landing.foundation_name') }} untuk mendukung minat baca, pengetahuan, dan cita-cita seluruh anak didik yayasan.
                    </p>

                    {{-- Featured Badge Card --}}
                    <div class="flex items-center gap-4 p-3.5 rounded-2xl bg-slate-900/50 backdrop-blur-md border border-white/20 max-w-md shadow-xl hover:border-emerald-400/40 transition-all">
                        <img src="{{ asset('images/reading-library-2.jpg') }}" alt="Anak-anak membaca" class="w-12 h-12 rounded-xl object-cover border border-white/40 shadow-md flex-shrink-0">
                        <div>
                            <p class="text-xs font-black text-white">Kegiatan Membaca Bersama</p>
                            <p class="text-[11px] text-emerald-200/90 font-medium mt-0.5">Ribuan koleksi buku cerita &amp; ilmu pengetahuan tersedia gratis.</p>
                        </div>
                    </div>
                </div>

                {{-- Right Login Card Floating overlay --}}
                <div class="lg:col-span-6 xl:col-span-5 flex justify-center lg:justify-end">
                    <div class="w-full max-w-md bg-white/95 backdrop-blur-2xl rounded-3xl p-7 sm:p-9 shadow-2xl shadow-emerald-950/80 border border-white/80 ring-1 ring-black/5">
                        {{ $slot }}
                    </div>
                </div>

            </main>

            {{-- Footer --}}
            <footer class="py-2 text-center lg:text-left text-[11px] text-emerald-200/80 font-semibold tracking-wide text-shadow-md">
                {{ __('landing.footer_copyright', ['year' => date('Y')]) }}
            </footer>

        </div>

    </body>
</html>
