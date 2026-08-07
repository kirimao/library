<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-black text-gray-900">{{ __('loans.process_return') }}</h1>
        </div>
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

    {{-- Search Bar & Page Size Selector --}}
    <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text"
                   placeholder="{{ __('books.search_placeholder') }}"
                   class="form-input pl-10 w-full">
        </div>
        <div class="flex items-center gap-2 flex-shrink-0">
            <label class="text-xs font-bold text-gray-500 whitespace-nowrap">{{ __('common.show') }}</label>
            <select wire:model.live="perPage"
                    class="form-select text-xs py-2 rounded-xl border-gray-300 font-bold text-gray-700 shadow-sm cursor-pointer"
                    style="padding-right: 2.25rem !important; padding-left: 0.75rem !important; min-width: 92px !important; text-align: center !important;">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr>
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-left">{{ __('loans.book') }}</th>
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-left">{{ __('loans.member') }}</th>
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-left">{{ __('loans.loan_date') }}</th>
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-left">{{ __('loans.due_date') }}</th>
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-center">{{ __('loans.reading_status') }}</th>
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-right">{{ __('loans.fine_amount') }}</th>
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-right">{{ __('common.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($loans as $loan)
                        @php
                            $isOverdue = !in_array($loan->status, ['returned', 'hilang']) && $loan->due_date < now()->toDateString();
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3.5 px-4">
                                <a href="{{ route('books.show', $loan->book->id ?? 0) }}" class="text-sm font-bold text-gray-900 hover:text-brand-600 leading-tight">
                                    {{ $loan->book->title ?? '-' }}
                                </a>
                                <p class="text-xs font-mono text-gray-400 mt-0.5">{{ $loan->book->isbn ?? '-' }}</p>
                            </td>
                            <td class="py-3.5 px-4">
                                <a href="{{ route('members.show', $loan->member->id ?? 0) }}" class="text-sm font-semibold text-gray-900 hover:text-brand-600 leading-tight">
                                    {{ $loan->member->name ?? '-' }}
                                </a>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <span class="badge-neutral text-[10px]">{{ __('members.type_' . ($loan->member->member_type ?? 'SD')) }}</span>
                                    <span class="text-xs font-mono text-brand-600 font-bold">{{ $loan->member->member_number ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-xs text-gray-500">
                                <span class="block">{{ $loan->loan_date->format('d M Y') }}</span>
                                <span class="text-[10px] font-mono text-gray-400">{{ $loan->loan_date->format('H:i') }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-xs font-semibold {{ $isOverdue ? 'text-red-600' : 'text-gray-700' }}">
                                {{ $loan->due_date->format('d M Y') }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($loan->status === 'hilang')
                                    <span class="badge-danger text-xs font-bold">⚠️ Hilang</span>
                                @elseif($loan->reading_status === 'selesai_dibaca')
                                    <span class="badge-success">{{ __('loans.status_selesai_dibaca') }}</span>
                                @elseif($loan->reading_status === 'belum_selesai')
                                    <span class="badge-warning">{{ __('loans.status_belum_selesai') }}</span>
                                @else
                                    <span class="badge-neutral">{{ __('loans.status_sedang_dibaca') }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right font-mono text-xs">
                                @if($loan->status === 'hilang')
                                    <span class="text-red-600 font-bold block">Rp{{ number_format($loan->fine_amount ?? 0) }}</span>
                                    <span class="text-[10px] text-red-500 font-semibold block">(Ganti Rugi)</span>
                                @elseif($loan->status === 'returned')
                                    <span class="text-gray-400 block">Rp{{ number_format($loan->fine_amount ?? 0) }}</span>
                                @elseif(($loan->estimated_fine ?? 0) > 0)
                                    <span class="text-red-600 font-bold block">Rp{{ number_format($loan->estimated_fine) }}</span>
                                @else
                                    <span class="text-gray-300">—</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                @if(!in_array($loan->status, ['returned', 'hilang']))
                                    <button wire:click="openReturnModal({{ $loan->id }})"
                                            class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs inline-flex items-center gap-1.5 shadow-sm transition-all active:scale-95">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>{{ __('loans.process_return') }}</span>
                                    </button>
                                @elseif($loan->status === 'hilang')
                                    <div class="text-right">
                                        <span class="text-xs text-red-600 font-bold italic block">
                                            Dilaporkan Hilang
                                        </span>
                                        <span class="text-[10px] text-gray-400 font-mono block">
                                            {{ $loan->reported_lost_at?->format('d M Y, H:i') ?? $loan->return_date?->format('d M Y, H:i') }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 italic">{{ __('loans.status_returned') }} {{ $loan->return_date?->format('d M Y, H:i') }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-gray-400 text-sm">{{ __('common.no_data') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-gray-100 bg-gray-50">
            {{ $loans->links() }}
        </div>
    </div>

    {{-- Return Modal --}}
    @if($isReturnModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" wire:click="closeReturnModal"></div>
            <div class="relative bg-white rounded-3xl border border-gray-100 shadow-2xl p-6 w-full my-auto z-10" style="max-width: 480px; width: 100%; margin-left: auto; margin-right: auto;">
                <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-100">
                    <h3 class="text-base font-bold text-gray-900">
                        {{ __('loans.confirm_return_modal') }}
                    </h3>
                    <button wire:click="closeReturnModal" class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="confirmReturn" class="space-y-4">
                    @if($selectedLoan)
                        <div class="p-3.5 bg-gray-50 rounded-2xl border border-gray-100 space-y-1">
                            <h4 class="text-sm font-bold text-gray-900">{{ $selectedLoan->book->title ?? '-' }}</h4>
                            <p class="text-xs text-gray-500">Peminjam: <span class="font-semibold text-gray-700">{{ $selectedLoan->member->name ?? '-' }}</span> ({{ $selectedLoan->member->member_number ?? '-' }})</p>
                            <p class="text-xs text-gray-400">Dipinjam: <span class="font-semibold text-gray-700">{{ $selectedLoan->loan_date?->format('d M Y, H:i') }}</span></p>
                            <p class="text-xs text-gray-400">Jatuh Tempo: <span class="font-semibold text-gray-700">{{ $selectedLoan->due_date?->format('d M Y') }}</span></p>
                        </div>
                    @endif

                    <div>
                        <label class="form-label">Kondisi Pengembalian</label>
                        <select wire:model.live="returnCondition" class="form-select font-bold">
                            <option value="normal">✅ Normal (Buku Dikembalikan Fisik)</option>
                            <option value="lost">⚠️ BUKU HILANG (Ganti Rugi / Denda Ditetapkan)</option>
                        </select>
                    </div>

                    @if($returnCondition === 'lost')
                        <div class="p-4 rounded-2xl bg-red-50 border border-red-200 space-y-3">
                            <div class="flex items-center gap-2 text-xs font-bold text-red-800">
                                <svg class="w-4 h-4 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <span>Pelaporan Buku Hilang:</span>
                            </div>
                            <p class="text-[11px] text-red-700">Stok buku fisik akan dikurangi 1. Denda ganti rugi buku di bawah akan dibebankan ke anggota.</p>
                            <div>
                                <label class="form-label text-red-900">Nominal Denda Ganti Rugi (Rp)</label>
                                <input type="number" wire:model="lostFee" class="form-input font-mono font-bold text-red-700" placeholder="50000">
                            </div>
                        </div>
                    @else
                        {{-- Fine Alert Box --}}
                        @if($calculatedFine > 0)
                            <div class="p-3.5 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 space-y-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold flex items-center gap-1.5 text-amber-800">
                                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                        Terlambat Dikembalikan!
                                    </span>
                                    <span class="text-sm font-black font-mono text-red-600">Rp {{ number_format($calculatedFine) }}</span>
                                </div>
                                <p class="text-[11px] text-amber-700">Denda keterlambatan ini dihitung otomatis dari sistem.</p>
                            </div>
                        @else
                            <div class="p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between">
                                <span>Status Denda:</span>
                                <span class="font-bold text-emerald-700">Tepat Waktu (Rp 0)</span>
                            </div>
                        @endif
                    @endif

                    <div>
                        <label class="form-label">{{ __('loans.is_completed_reading') }}</label>
                        <select wire:model="readingStatus" class="form-select">
                            <option value="selesai_dibaca">{{ __('loans.status_selesai_dibaca') }}</option>
                            <option value="belum_selesai">{{ __('loans.status_belum_selesai') }}</option>
                        </select>
                    </div>

                    <div>
                        <label class="form-label">{{ __('loans.optional_comment') }}</label>
                        <textarea wire:model="comment" rows="3" class="form-input"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <button type="button" wire:click="closeReturnModal" class="px-4 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-sm transition-all">
                            {{ __('common.cancel') }}
                        </button>
                        <button type="submit" class="btn-primary">{{ __('loans.process_return') }}</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
