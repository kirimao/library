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

    <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text"
                   placeholder="{{ __('books.search_placeholder') }}"
                   class="form-input pl-10">
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
                            $isOverdue = $loan->status !== 'returned' && $loan->due_date < now()->toDateString();
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
                            <td class="py-3.5 px-4 text-xs text-gray-500">{{ $loan->loan_date->format('d M Y') }}</td>
                            <td class="py-3.5 px-4 text-xs font-semibold {{ $isOverdue ? 'text-red-600' : 'text-gray-700' }}">
                                {{ $loan->due_date->format('d M Y') }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($loan->reading_status === 'selesai_dibaca')
                                    <span class="badge-success">{{ __('loans.status_selesai_dibaca') }}</span>
                                @elseif($loan->reading_status === 'belum_selesai')
                                    <span class="badge-warning">{{ __('loans.status_belum_selesai') }}</span>
                                @else
                                    <span class="badge-neutral">{{ __('loans.status_sedang_dibaca') }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right font-mono text-xs">
                                @if($loan->status === 'returned')
                                    <span class="text-gray-400">Rp{{ number_format($loan->fine_amount ?? 0) }}</span>
                                @elseif(($loan->estimated_fine ?? 0) > 0)
                                    <span class="text-red-600 font-bold">Rp{{ number_format($loan->estimated_fine) }}</span>
                                @else
                                    <span class="text-gray-300">—</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                @if($loan->status !== 'returned')
                                    <button wire:click="openReturnModal({{ $loan->id }})"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs transition-all shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ __('loans.process_return') }}
                                    </button>
                                @else
                                    <span class="text-xs text-gray-300 italic">{{ __('loans.status_returned') }} {{ $loan->return_date?->format('d M Y') }}</span>
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
