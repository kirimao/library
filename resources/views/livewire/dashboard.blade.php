<div class="space-y-6">

    {{-- Welcome Banner --}}
    <div class="relative overflow-hidden rounded-2xl p-6 shadow-lg" style="background-color: #0e8a3e;">
        {{-- Decorative circles --}}
        <div class="pointer-events-none absolute -top-6 -right-6 w-40 h-40 rounded-full" style="background:rgba(255,255,255,0.08);"></div>
        <div class="pointer-events-none absolute bottom-0 left-1/3 w-48 h-24 rounded-full" style="background:rgba(0,0,0,0.1);"></div>
        <div class="pointer-events-none absolute top-4 right-40 w-16 h-16 rounded-full" style="background:rgba(255,255,255,0.06);"></div>

        <div class="relative flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                {{-- Institution badge --}}
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 text-white text-xs font-bold mb-3">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Perpustakaan YPA — Yayasan Peduli Anak
                </div>
                <h1 class="text-xl sm:text-2xl font-black text-white tracking-tight">
                    Selamat datang, {{ explode(' ', Auth::user()->name)[0] }}! 👋
                </h1>
                <p class="text-white/70 text-sm mt-1.5">
                    Ringkasan aktivitas perpustakaan hari ini.
                </p>
            </div>
            <a href="{{ route('loans.create') }}"
               class="flex-shrink-0 inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white font-bold text-sm shadow-sm active:scale-95 transition-all hover:bg-green-50"
               style="color: #0b7233;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('nav.borrow') }}
            </a>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">

        {{-- Total Books --}}
        <div class="stat-card">
            <div class="flex items-start justify-between gap-2">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-400">{{ __('dashboard.total_books') }}</p>
                <div class="w-9 h-9 flex-shrink-0 rounded-xl bg-brand-50 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
            <p class="mt-4 text-3xl font-black text-gray-900 tabular-nums">{{ number_format($totalBooks) }}</p>
            <p class="text-xs text-gray-400 mt-1">Judul tersedia</p>
        </div>

        {{-- Active Members --}}
        <div class="stat-card">
            <div class="flex items-start justify-between gap-2">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-400">{{ __('dashboard.total_members') }}</p>
                <div class="w-9 h-9 flex-shrink-0 rounded-xl bg-blue-50 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
            <p class="mt-4 text-3xl font-black text-gray-900 tabular-nums">{{ number_format($totalMembers) }}</p>
            <p class="text-xs text-gray-400 mt-1">Anggota aktif</p>
        </div>

        {{-- Borrowed --}}
        <div class="stat-card">
            <div class="flex items-start justify-between gap-2">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-400">{{ __('dashboard.total_borrowed') }}</p>
                <div class="w-9 h-9 flex-shrink-0 rounded-xl bg-amber-50 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                </div>
            </div>
            <p class="mt-4 text-3xl font-black text-gray-900 tabular-nums">{{ number_format($totalBorrowed) }}</p>
            <p class="text-xs text-gray-400 mt-1">Sedang dipinjam</p>
        </div>

        {{-- Overdue --}}
        <div class="stat-card {{ $totalOverdue > 0 ? 'border-red-200 bg-red-50' : '' }}">
            <div class="flex items-start justify-between gap-2">
                <p class="text-xs font-bold uppercase tracking-wider {{ $totalOverdue > 0 ? 'text-red-400' : 'text-gray-400' }}">{{ __('dashboard.total_overdue') }}</p>
                <div class="w-9 h-9 flex-shrink-0 rounded-xl bg-red-50 flex items-center justify-center {{ $totalOverdue > 0 ? 'bg-red-100' : '' }}">
                    <svg class="w-4.5 h-4.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="mt-4 text-3xl font-black {{ $totalOverdue > 0 ? 'text-red-600' : 'text-gray-900' }} tabular-nums">{{ number_format($totalOverdue) }}</p>
            <p class="text-xs mt-1 {{ $totalOverdue > 0 ? 'text-red-400' : 'text-gray-400' }}">
                @if($totalOverdue > 0)
                    <a href="{{ route('loans.overdue') }}" class="hover:underline font-semibold">Lihat detail →</a>
                @else
                    Semua tepat waktu ✓
                @endif
            </p>
        </div>

    </div>

    {{-- Tables --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Popular Books --}}
        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    {{ __('dashboard.popular_books') }}
                </h3>
                <a href="{{ route('books.index') }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700 transition-colors">{{ __('dashboard.view_all') }} →</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($popularBooks as $i => $book)
                    <div class="flex items-center gap-4 px-5 py-3.5 hover:bg-gray-50 transition-colors">
                        <span class="text-xs font-black w-5 text-center {{ $i === 0 ? 'text-amber-500' : ($i === 1 ? 'text-gray-400' : ($i === 2 ? 'text-orange-400' : 'text-gray-300')) }}">
                            #{{ $i + 1 }}
                        </span>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $book->title }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ $book->author }}</p>
                        </div>
                        <span class="flex-shrink-0 inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-brand-50 text-brand-700 tabular-nums">
                            {{ $book->loans_count }}×
                        </span>
                    </div>
                @empty
                    <p class="px-5 py-8 text-center text-sm text-gray-400">{{ __('common.no_data') }}</p>
                @endforelse
            </div>
        </div>

        {{-- Recent Loans --}}
        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ __('dashboard.recent_loans') }}
                </h3>
                <a href="{{ route('loans.return') }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700 transition-colors">{{ __('dashboard.view_all') }} →</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($recentLoans as $loan)
                    @php
                        $isOverdue = $loan->status !== 'returned' && $loan->due_date < now();
                        $badgeClass = $loan->status === 'returned' ? 'badge-success' :
                                      ($isOverdue ? 'badge-danger' : 'badge-warning');
                        $statusLabel = $loan->status === 'returned' ? __('loans.status_returned') :
                                       ($isOverdue ? __('loans.status_overdue') : __('loans.status_borrowed'));
                    @endphp
                    <div class="flex items-center gap-4 px-5 py-3.5 hover:bg-gray-50 transition-colors">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $loan->book->title ?? '-' }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ $loan->member->name ?? '-' }}</p>
                        </div>
                        <div class="flex-shrink-0 text-right">
                            <span class="{{ $badgeClass }}">{{ $statusLabel }}</span>
                            <p class="text-[11px] text-gray-400 mt-1">{{ $loan->due_date->format('d M Y') }}</p>
                        </div>
                    </div>
                @empty
                    <p class="px-5 py-8 text-center text-sm text-gray-400">{{ __('common.no_data') }}</p>
                @endforelse
            </div>
        </div>

    </div>

</div>
