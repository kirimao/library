<div class="space-y-6">
    {{-- Header & Back button --}}
    <div class="flex items-center justify-between gap-4">
        <a href="{{ route('books.index') }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs transition-all">
            {{ __('books.back_to_catalog') }}
        </a>
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

    {{-- Book Card Header --}}
    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm flex flex-col md:flex-row justify-between gap-6">
        <div class="space-y-3 flex-1">
            <div class="flex flex-wrap items-center gap-2">
                <span class="badge-neutral">{{ $book->category->name ?? '-' }}</span>
                @foreach($book->genres as $g)
                    <span class="badge-success text-xs">{{ $g->name }}</span>
                @endforeach
                @if($book->isNewArrival())
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 border border-emerald-300">
                        ✨ Buku Baru (Kedatangan ≥ 2025)
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                        📦 Buku Lama (Kedatangan < 2025)
                    </span>
                @endif
            </div>

            <h1 class="text-2xl font-black text-gray-900 leading-tight">{{ $book->title }}</h1>
            <p class="text-sm font-semibold text-gray-600">{{ __('books.author') }}: <span class="text-gray-900">{{ $book->author }}</span></p>

            <div class="grid grid-cols-2 sm:grid-cols-5 gap-4 pt-2 text-xs text-gray-500">
                <div>
                    <span class="block text-gray-400 font-bold uppercase tracking-wider text-[10px]">{{ __('books.isbn') }}</span>
                    <span class="font-mono font-bold text-gray-800">{{ $book->isbn }}</span>
                </div>
                <div>
                    <span class="block text-gray-400 font-bold uppercase tracking-wider text-[10px]">{{ __('books.publisher') }} / {{ __('books.year') }}</span>
                    <span class="font-semibold text-gray-800">{{ $book->publisher ?? '-' }} ({{ $book->year ?? '-' }})</span>
                </div>
                <div>
                    <span class="block text-gray-400 font-bold uppercase tracking-wider text-[10px]">Waktu Kedatangan</span>
                    <span class="font-semibold text-brand-700">
                        @if($book->arrival_month || $book->arrival_year)
                            {{ $book->arrival_month_name }} {{ $book->arrival_year }}
                        @else
                            -
                        @endif
                    </span>
                </div>
                <div>
                    <span class="block text-gray-400 font-bold uppercase tracking-wider text-[10px]">{{ __('books.shelf_location') }}</span>
                    <span class="font-mono font-bold text-gray-800">{{ $book->shelf_location ?? '-' }}</span>
                </div>
                <div>
                    <span class="block text-gray-400 font-bold uppercase tracking-wider text-[10px]">{{ __('books.available_copies') }}</span>
                    <span class="font-bold text-gray-800">{{ $book->available_copies }} / {{ $book->total_copies }}</span>
                </div>
            </div>
        </div>

        <div class="flex-shrink-0 flex flex-col justify-between items-end">
            <span class="{{ $book->available_copies > 0 ? 'badge-success' : 'badge-danger' }} text-sm px-3 py-1.5">
                {{ $book->available_copies > 0 ? __('books.in_stock') : __('books.out_of_stock') }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Readers List (2 Cols) --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        {{ __('books.book_readers') }} ({{ $readers->count() }})
                    </h3>
                </div>

                <div class="divide-y divide-gray-100">
                    @forelse($readers as $loan)
                        <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div>
                                <a href="{{ route('members.show', $loan->member->id ?? 0) }}" class="text-sm font-bold text-gray-900 hover:text-brand-600">
                                    {{ $loan->member->name ?? '-' }}
                                </a>
                                <div class="flex items-center gap-2 text-xs text-gray-400 mt-0.5">
                                    <span class="badge-neutral text-[10px]">{{ __('members.type_' . ($loan->member->member_type ?? 'SD')) }}</span>
                                    @if($loan->status === 'on_site')
                                        <span class="inline-flex items-center gap-1 text-[10px] font-semibold text-purple-600 bg-purple-50 px-2 py-0.5 rounded-full border border-purple-200">📍 Baca di Tempat</span>
                                    @else
                                        <span>{{ __('loans.loan_date') }}: {{ $loan->loan_date->format('d M Y') }}</span>
                                        @if($loan->return_date)
                                            <span>· {{ __('loans.return_date') }}: {{ $loan->return_date->format('d M Y') }}</span>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <div>
                                @if($loan->reading_status === 'selesai_dibaca')
                                    <span class="badge-success text-xs">{{ __('loans.status_selesai_dibaca') }}</span>
                                @elseif($loan->reading_status === 'belum_selesai')
                                    <span class="badge-warning text-xs">{{ __('loans.status_belum_selesai') }}</span>
                                @else
                                    <span class="badge-neutral text-xs">{{ __('loans.status_sedang_dibaca') }}</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="py-8 text-center text-sm text-gray-400">{{ __('books.no_readers') }}</p>
                    @endforelse
                </div>
            </div>

            {{-- Reviews List --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                        {{ __('books.book_reviews') }} ({{ $book->reviews->count() }})
                    </h3>
                </div>

                <div class="space-y-3">
                    @forelse($book->reviews as $review)
                        <div class="p-4 rounded-xl bg-gray-50 border border-gray-100 space-y-1.5">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-gray-900">{{ $review->member->name ?? '-' }}</span>
                                <span class="text-[11px] text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-gray-700 leading-relaxed font-serif">"{{ $review->comment }}"</p>
                        </div>
                    @empty
                        <p class="py-6 text-center text-sm text-gray-400">{{ __('books.no_reviews') }}</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Add Review Form (1 Col) --}}
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm space-y-4">
                <h3 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-3">
                    {{ __('books.add_review') }}
                </h3>

                <form wire:submit.prevent="addReview" class="space-y-4">
                    <div>
                        <label class="form-label">{{ __('books.select_member_for_review') }}</label>
                        <select wire:model="selectedMemberId" class="form-select">
                            <option value="">{{ __('loans.select_member') }}</option>
                            @foreach($members as $m)
                                <option value="{{ $m->id }}">{{ $m->member_number }} - {{ $m->name }} ({{ __('members.type_' . $m->member_type) }})</option>
                            @endforeach
                        </select>
                        @error('selectedMemberId') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="form-label">{{ __('loans.is_completed_reading') }}</label>
                        <select wire:model="readingStatus" class="form-select">
                            <option value="sedang_dibaca">{{ __('loans.status_sedang_dibaca') }}</option>
                            <option value="selesai_dibaca">{{ __('loans.status_selesai_dibaca') }}</option>
                            <option value="belum_selesai">{{ __('loans.status_belum_selesai') }}</option>
                        </select>
                        @error('readingStatus') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="form-label">{{ __('books.review_comment') }}</label>
                        <textarea wire:model="comment" rows="4" class="form-input"></textarea>
                        @error('comment') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="btn-primary w-full justify-center">{{ __('books.save_review') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
