<div class="relative inline-block text-left" x-data="{ open: false }">
    <button @click="open = !open" type="button" class="inline-flex items-center gap-x-2 rounded-lg bg-white/10 dark:bg-slate-800/80 px-3 py-2 text-sm font-semibold text-slate-700 dark:text-slate-200 shadow-sm ring-1 ring-inset ring-slate-300 dark:ring-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">
        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
        </svg>
        <span class="uppercase tracking-wider font-bold text-xs">{{ $currentLocale }}</span>
        <span class="text-xs text-slate-400">({{ strtoupper($currentLocale) }})</span>
        <svg class="-mr-1 h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
        </svg>
    </button>

    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" class="absolute right-0 z-50 mt-2 w-48 origin-top-right rounded-xl bg-white dark:bg-slate-800 p-1.5 shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none" style="display: none;">
        <button wire:click="switchLanguage('id')" @click="open = false" class="w-full text-left flex items-center gap-3 px-3 py-2 text-sm rounded-lg hover:bg-emerald-50 dark:hover:bg-slate-700/60 {{ $currentLocale === 'id' ? 'text-emerald-600 font-bold bg-emerald-50/50 dark:bg-emerald-950/30' : 'text-slate-700 dark:text-slate-300' }}">
            <span class="font-bold text-xs text-emerald-700 w-5">ID</span>
            <span>{{ __('nav.indonesian') }}</span>
        </button>
        <button wire:click="switchLanguage('en')" @click="open = false" class="w-full text-left flex items-center gap-3 px-3 py-2 text-sm rounded-lg hover:bg-emerald-50 dark:hover:bg-slate-700/60 {{ $currentLocale === 'en' ? 'text-emerald-600 font-bold bg-emerald-50/50 dark:bg-emerald-950/30' : 'text-slate-700 dark:text-slate-300' }}">
            <span class="font-bold text-xs text-emerald-700 w-5">EN</span>
            <span>{{ __('nav.english') }}</span>
        </button>
    </div>
</div>
