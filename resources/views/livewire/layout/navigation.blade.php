<?php

use App\Actions\Loan\GetOverdueLoansAction;
use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    public int $overdueCount = 0;

    public function mount(GetOverdueLoansAction $getOverdueLoansAction)
    {
        $this->overdueCount = $getOverdueLoansAction->count();
    }

    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}; ?>

{{-- Sidebar: Dark Green Background --}}
<aside class="flex flex-col h-full overflow-y-auto overflow-x-hidden" style="background-color: #0b7233;">

    {{-- Brand --}}
    <div class="flex h-16 flex-shrink-0 items-center px-5 border-b" style="border-color: rgba(255,255,255,0.12);">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 min-w-0 group">
            <img src="{{ asset('images/logoypa.png') }}"
                 alt="Logo YPA"
                 class="h-9 w-9 flex-shrink-0 rounded-xl object-contain bg-white/90 p-1 group-hover:bg-white transition-colors">
            <div class="min-w-0">
                <p class="font-extrabold text-sm text-white leading-tight truncate">{{ __('landing.hero_library_name') }}</p>
                <p class="text-[10px] font-semibold text-white/60 mt-0.5 truncate">{{ __('landing.foundation_name') }}</p>
            </div>
        </a>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 p-3 space-y-0.5">

        <p class="px-3 pt-2 pb-1.5 text-[10px] uppercase tracking-widest font-bold text-white/40">{{ __('nav.main_menu') }}</p>

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
                  {{ request()->routeIs('dashboard')
                      ? 'bg-white text-brand-700 shadow-sm'
                      : 'text-white/75 hover:text-white hover:bg-white/15' }}">
            <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3
                         m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>{{ __('nav.dashboard') }}</span>
        </a>

        {{-- Books --}}
        <a href="{{ route('books.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
                  {{ request()->routeIs('books.*')
                      ? 'bg-white text-brand-700 shadow-sm'
                      : 'text-white/75 hover:text-white hover:bg-white/15' }}">
            <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13
                         C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13
                         C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13
                         C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <span>{{ __('nav.books') }}</span>
        </a>

        {{-- Master Kategori --}}
        <a href="{{ route('categories.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
                  {{ request()->routeIs('categories.*')
                      ? 'bg-white text-brand-700 shadow-sm'
                      : 'text-white/75 hover:text-white hover:bg-white/15' }}">
            <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            <span>{{ __('nav.categories') }}</span>
        </a>

        {{-- Master Genre --}}
        <a href="{{ route('genres.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
                  {{ request()->routeIs('genres.*')
                      ? 'bg-white text-brand-700 shadow-sm'
                      : 'text-white/75 hover:text-white hover:bg-white/15' }}">
            <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M7 7h.01M7 11h.01M7 15h.01M13 7h7M13 11h7M13 15h7M4 6h16a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2z"/>
            </svg>
            <span>{{ __('nav.genres') }}</span>
        </a>

        {{-- Members --}}
        <a href="{{ route('members.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
                  {{ request()->routeIs('members.*')
                      ? 'bg-white text-brand-700 shadow-sm'
                      : 'text-white/75 hover:text-white hover:bg-white/15' }}">
            <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857
                         M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857
                         m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span>{{ __('nav.members') }}</span>
        </a>

        {{-- Divider --}}
        <div class="!my-3 border-t" style="border-color: rgba(255,255,255,0.12);"></div>
        <p class="px-3 pb-1.5 text-[10px] uppercase tracking-widest font-bold text-white/40">{{ __('nav.circulation_reports') }}</p>

        {{-- Borrow --}}
        <a href="{{ route('loans.create') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
                  {{ request()->routeIs('loans.create')
                      ? 'bg-white text-brand-700 shadow-sm'
                      : 'text-white/75 hover:text-white hover:bg-white/15' }}">
            <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
            </svg>
            <span>{{ __('nav.borrow') }}</span>
        </a>

        {{-- Return --}}
        <a href="{{ route('loans.return') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
                  {{ request()->routeIs('loans.return')
                      ? 'bg-white text-brand-700 shadow-sm'
                      : 'text-white/75 hover:text-white hover:bg-white/15' }}">
            <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ __('nav.return') }}</span>
        </a>

        {{-- Overdue --}}
        <a href="{{ route('loans.overdue') }}"
           class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
                  {{ request()->routeIs('loans.overdue')
                      ? 'bg-white text-brand-700 shadow-sm'
                      : 'text-white/75 hover:text-white hover:bg-white/15' }}">
            <div class="flex items-center gap-3 min-w-0">
                <svg class="w-[18px] h-[18px] flex-shrink-0 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="truncate">{{ __('nav.overdue') }}</span>
            </div>
            <span class="flex-shrink-0 ml-2 inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full text-[10px] font-black
                         {{ $overdueCount > 0 ? 'bg-red-500 text-white' : 'bg-white/20 text-white/60' }}">
                {{ $overdueCount }}
            </span>
        </a>

        {{-- Laporan Populer --}}
        <a href="{{ route('reports.popular') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
                  {{ request()->routeIs('reports.popular')
                      ? 'bg-white text-brand-700 shadow-sm'
                      : 'text-white/75 hover:text-white hover:bg-white/15' }}">
            <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 19v-6a2 2 0 012-2h2a2 2 0 012 2v6a2 2 0 01-2 2h-2a2 2 0 01-2-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            <span>{{ __('nav.popular_reports') }}</span>
        </a>

        {{-- Admin Menu --}}
        @if(Auth::user()->isAdmin())
        <a href="{{ route('users.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
                  {{ request()->routeIs('users.*')
                      ? 'bg-white text-brand-700 shadow-sm'
                      : 'text-white/75 hover:text-white hover:bg-white/15' }}">
            <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <span>{{ __('nav.users') }}</span>
        </a>

        <a href="{{ route('login-logs.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150
                  {{ request()->routeIs('login-logs.index')
                      ? 'bg-white text-brand-700 shadow-sm'
                      : 'text-white/75 hover:text-white hover:bg-white/15' }}">
            <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
            <span>{{ __('nav.login_logs') }}</span>
        </a>
        @endif

    </nav>

    {{-- Footer --}}
    <div class="flex-shrink-0 p-3 border-t" style="border-color: rgba(255,255,255,0.12);">
        {{-- User info --}}
        <div class="flex items-center gap-3 px-3 py-2 mb-1">
            <div class="h-8 w-8 rounded-full bg-white/20 flex items-center justify-center font-bold text-white text-sm flex-shrink-0">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="min-w-0">
                <p class="text-sm font-semibold text-white truncate leading-none">{{ Auth::user()->name }}</p>
                <p class="text-xs text-white/50 truncate mt-0.5">{{ Auth::user()->email }} ({{ strtoupper(Auth::user()->role ?? 'librarian') }})</p>
            </div>
        </div>

        {{-- Logout --}}
        <button wire:click="logout"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-white/60 hover:text-white hover:bg-white/10 transition-all duration-150">
            <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            <span>{{ __('nav.logout') }}</span>
        </button>
    </div>

</aside>
