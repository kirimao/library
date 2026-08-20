<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ __('landing.hero_library_name') }} — {{ __('landing.foundation_name') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/logoypa.png') }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="h-full antialiased bg-gray-50 text-gray-900" style="font-family: 'Inter', sans-serif;">

        <div class="flex h-screen overflow-hidden">

            {{-- SIDEBAR (Desktop) --}}
            <div class="hidden lg:flex lg:flex-shrink-0">
                <div class="flex flex-col w-64">
                    <livewire:layout.navigation />
                </div>
            </div>

            {{-- MAIN CONTENT --}}
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

                {{-- Top Header --}}
                <header class="flex-shrink-0 flex h-16 items-center justify-between gap-4 bg-white px-4 sm:px-6 lg:px-8 z-20"
                        style="border-bottom: 3px solid #12a24a;">

                    {{-- Left: hamburger (mobile) + breadcrumb (desktop) --}}
                    <div class="flex items-center gap-3">
                        <button @click="$dispatch('toggle-mobile-sidebar')"
                                class="lg:hidden p-2 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>

                        {{-- Brand (mobile only) --}}
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 lg:hidden">
                            <img src="{{ asset('images/logoypa.png') }}"
                                 alt="Logo YPA"
                                 class="h-8 w-8 rounded-lg object-contain bg-white p-0.5 border border-gray-200">
                            <div>
                                <p class="font-extrabold text-sm text-gray-900 leading-none">Perpustakaan YPA</p>
                                <p class="text-[10px] text-gray-400">Yayasan Peduli Anak</p>
                            </div>
                        </a>

                        {{-- Breadcrumb / Role (desktop) --}}
                        <div class="hidden lg:flex items-center gap-2">
                            <span class="inline-flex items-center rounded-lg px-3 py-1.5 text-xs font-bold text-white"
                                  style="background-color: #12a24a;">
                                {{ Auth::user()->role === 'admin' ? __('nav.role_admin') : __('nav.role_librarian') }}
                            </span>
                        </div>
                    </div>

                    {{-- Right: Language + User --}}
                    <div class="flex items-center gap-4">
                        <livewire:language-switcher />
                        <div class="h-5 w-px bg-gray-200 hidden sm:block"></div>
                        <div class="flex items-center gap-3">
                            <div class="h-9 w-9 rounded-full flex items-center justify-center font-extrabold text-white text-sm shadow-sm"
                                 style="background-color: #12a24a;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-semibold text-gray-900 leading-none">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>
                </header>

                {{-- Page Content --}}
                <main class="flex-1 overflow-y-auto bg-gray-50">
                    <div class="p-4 sm:p-6 lg:p-8 max-w-screen-2xl w-full mx-auto">
                        {{ $slot }}
                    </div>
                </main>
            </div>

        </div>

        {{-- Mobile Sidebar Drawer --}}
        <div x-data="{ open: false }" @toggle-mobile-sidebar.window="open = !open" class="lg:hidden">
            <div x-show="open"
                 x-transition:enter="transition-opacity ease-linear duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="open = false"
                 class="fixed inset-0 z-40 bg-black/50"></div>
            <div x-show="open"
                 x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="fixed inset-y-0 left-0 z-50 w-64 flex flex-col shadow-2xl">
                <livewire:layout.navigation />
            </div>
        </div>

    </body>
</html>
