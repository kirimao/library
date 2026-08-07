<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="w-full">
    {{-- Form Header --}}
    <div class="mb-6 text-center sm:text-left">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200 mb-2.5">
            <img src="{{ asset('images/logoypa.png') }}" alt="Logo YPA" class="w-4 h-4 object-contain">
            Portal Petugas &amp; Admin
        </div>
        <h2 class="font-display text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Masuk ke Sistem</h2>
        <p class="text-xs sm:text-sm text-slate-500 mt-1 font-medium">Masukkan email dan kata sandi petugas perpustakaan Anda.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-4">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-1">
                Alamat Email
            </label>
            <div class="relative">
                <input wire:model="form.email" id="email" type="email" name="email" required autofocus autocomplete="username"
                       placeholder="contoh: petugas@ypa.sch.id"
                       class="w-full pl-11 pr-4 py-2.5 rounded-2xl border border-slate-300 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all font-medium">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                </div>
            </div>
            <x-input-error :messages="$errors->get('form.email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1">
                <label for="password" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700">
                    Kata Sandi
                </label>
                @if (Route::has('password.request'))
                    <a class="text-xs text-emerald-700 hover:text-emerald-900 font-bold hover:underline" href="{{ route('password.request') }}" wire:navigate>
                        Lupa kata sandi?
                    </a>
                @endif
            </div>
            <div class="relative">
                <input wire:model="form.password" id="password" type="password" name="password" required autocomplete="current-password"
                       placeholder="••••••••"
                       class="w-full pl-11 pr-4 py-2.5 rounded-2xl border border-slate-300 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all font-medium">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-0.5">
            <label for="remember" class="inline-flex items-center cursor-pointer group">
                <input wire:model="form.remember" id="remember" type="checkbox" class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 transition-all">
                <span class="ms-2 text-xs font-semibold text-slate-600 group-hover:text-slate-900">Ingat Saya di perangkat ini</span>
            </label>
        </div>

        {{-- Submit button --}}
        <button type="submit"
                class="w-full mt-3 inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl text-sm font-extrabold text-white bg-brand-600 hover:bg-brand-700 shadow-md shadow-emerald-900/15 hover:shadow-emerald-900/25 hover:-translate-y-0.5 active:scale-95 transition-all duration-200">
            Masuk ke Sistem Perpustakaan
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </button>

    </form>
</div>
