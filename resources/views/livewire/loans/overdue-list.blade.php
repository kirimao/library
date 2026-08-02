<div class="space-y-6">
    <div>
        <h1 class="text-xl font-black text-red-600 flex items-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ __('loans.overdue_alert') }}
        </h1>
        <p class="text-sm text-gray-400 mt-0.5">Daftar anggota yang belum mengembalikan buku melebihi jatuh tempo</p>
    </div>

    @if(session()->has('success'))
        <div class="alert-success">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session()->has('error'))
        <div class="alert-danger">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        @forelse($overdueLoans as $loan)
            <div class="bg-white border border-red-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
                {{-- Top row: late badge + fine --}}
                <div class="flex items-start justify-between gap-4 mb-4">
                    <div class="flex-1 min-w-0">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-black bg-red-500 text-white">
                            {{ $loan->days_late }} hari terlambat
                        </span>
                        <h3 class="text-sm font-bold text-gray-900 mt-2 leading-tight truncate">{{ $loan->book->title ?? '-' }}</h3>
                        <p class="text-xs text-gray-400 font-mono mt-0.5">ISBN: {{ $loan->book->isbn ?? '-' }}</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Estimasi Denda</p>
                        <p class="text-xl font-black text-red-600 font-mono mt-0.5">Rp{{ number_format($loan->estimated_fine) }}</p>
                    </div>
                </div>

                {{-- Member info --}}
                <div class="p-3.5 rounded-xl bg-gray-50 border border-gray-100 space-y-2 mb-4">
                    <div class="flex items-center justify-between text-sm">
                        <span class="font-bold text-gray-900">{{ $loan->member->name ?? '-' }}</span>
                        <span class="font-mono text-xs text-brand-600 font-bold">{{ $loan->member->member_number ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col gap-1 text-xs text-gray-400 border-t border-gray-200 pt-2">
                        <span>✉ {{ $loan->member->email ?? '-' }}</span>
                        <span>☎ {{ $loan->member->phone ?? '-' }}</span>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-between">
                    <div class="text-xs text-gray-400">
                        Jatuh tempo: <span class="font-bold text-red-600">{{ $loan->due_date->format('d M Y') }}</span>
                    </div>
                    <button onclick="confirm('{{ __('loans.return_confirm') }}') || event.stopImmediatePropagation()"
                            wire:click="processReturn({{ $loan->id }})"
                            class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Proses Kembali
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-2 py-16 text-center rounded-2xl bg-white border border-gray-200">
                <div class="w-14 h-14 rounded-full bg-brand-50 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-900">Tidak Ada Peminjaman Terlambat!</h3>
                <p class="text-sm text-gray-400 mt-1">Semua peminjaman buku berada dalam periode aman.</p>
            </div>
        @endforelse
    </div>
</div>
