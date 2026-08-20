<div class="space-y-6">
    {{-- Header & Back button --}}
    <div class="flex items-center justify-between gap-4">
        <a href="{{ route('books.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>{{ __('books.back_to_catalog') }}</span>
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

    {{-- Book Main Card --}}
    <div class="bg-white border border-gray-200 rounded-3xl p-6 sm:p-8 shadow-sm">
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 items-start">
            {{-- Cover Column --}}
            <div class="w-40 sm:w-48 flex-shrink-0 mx-auto sm:mx-0">
                <div class="relative aspect-[3/4] w-full rounded-2xl bg-slate-100 border border-slate-200 overflow-hidden shadow-md flex items-center justify-center text-slate-300">
                    @if(!empty($book->cover_image))
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="hidden p-4 text-center w-full h-full items-center justify-center flex-col bg-slate-100">
                            <svg class="w-12 h-12 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span class="text-xs font-semibold text-slate-400">Gambar tidak tersedia</span>
                        </div>
                    @elseif(!empty($book->cover_thumbnail))
                        <img src="{{ asset('storage/' . $book->cover_thumbnail) }}" alt="{{ $book->title }}" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="hidden p-4 text-center w-full h-full items-center justify-center flex-col bg-slate-100">
                            <svg class="w-12 h-12 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span class="text-xs font-semibold text-slate-400">Gambar tidak tersedia</span>
                        </div>
                    @else
                        <div class="p-4 text-center">
                            <svg class="w-12 h-12 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span class="text-xs font-semibold text-slate-400">Belum ada cover</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Info Column --}}
            <div class="flex-1 min-w-0 space-y-5 w-full">
                {{-- Top Bar: Category & Stock Status --}}
                <div class="flex flex-wrap items-center justify-between gap-3 pb-3 border-b border-gray-100">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-brand-50 text-brand-700 border border-brand-200">
                            {{ $book->category->name ?? 'Umum' }}
                        </span>
                        @if($book->isNewArrival())
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 border border-emerald-300">
                                ✨ Buku Baru (≥ 2025)
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                                📦 Buku Lama (< 2025)
                            </span>
                        @endif
                        @if($book->cover_type)
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                                📘 {{ $book->cover_type }}
                            </span>
                        @endif
                    </div>

                    <div>
                        @if($book->available_copies > 0)
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-black bg-emerald-500 text-white shadow-sm">
                                Tersedia ({{ $book->available_copies }}/{{ $book->total_copies }})
                            </span>
                        @else
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-black bg-red-500 text-white shadow-sm">
                                Stok Habis (0/{{ $book->total_copies }})
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Title & Author --}}
                <div class="space-y-1">
                    <h1 class="text-2xl sm:text-3xl font-black text-gray-900 leading-tight break-words">
                        {{ str_replace(';', ' ', $book->title) }}
                    </h1>
                    <p class="text-sm font-bold text-gray-500">
                        {{ __('books.by_author', ['author' => str_replace(';', ' ', $book->author)]) }}
                    </p>
                </div>

                {{-- Genres --}}
                @if($book->genres->count() > 0)
                    <div class="flex flex-wrap items-center gap-1.5">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mr-1">Genre:</span>
                        @foreach($book->genres as $g)
                            <span class="px-2.5 py-0.5 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                {{ $g->name }}
                            </span>
                        @endforeach
                    </div>
                @endif

                {{-- Metadata Grid (Metric Box Layout) --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 pt-2">
                    <div class="bg-gray-50 border border-gray-200/80 rounded-2xl p-3 space-y-0.5">
                        <span class="block text-[10px] font-bold uppercase tracking-wider text-gray-400">{{ __('books.isbn') }}</span>
                        <span class="font-mono text-xs font-bold text-gray-800 break-all leading-tight block">{{ $book->isbn }}</span>
                    </div>
                    <div class="bg-gray-50 border border-gray-200/80 rounded-2xl p-3 space-y-0.5">
                        <span class="block text-[10px] font-bold uppercase tracking-wider text-gray-400">{{ __('books.publisher') }} / {{ __('books.year') }}</span>
                        <span class="text-xs font-semibold text-gray-800 break-words leading-tight block">{{ str_replace(';', ' ', $book->publisher ?? '-') }} ({{ $book->year ?? '-' }})</span>
                    </div>
                    <div class="bg-gray-50 border border-gray-200/80 rounded-2xl p-3 space-y-0.5">
                        <span class="block text-[10px] font-bold uppercase tracking-wider text-gray-400">Harga Buku</span>
                        <span class="font-mono text-xs font-bold text-gray-800 leading-tight block">
                            {{ $book->price ? 'Rp ' . number_format($book->price) : '-' }}
                        </span>
                    </div>
                    <div class="bg-gray-50 border border-gray-200/80 rounded-2xl p-3 space-y-0.5">
                        <span class="block text-[10px] font-bold uppercase tracking-wider text-gray-400">Waktu Kedatangan</span>
                        <span class="text-xs font-bold text-emerald-700 leading-tight block">
                            @if($book->arrival_month || $book->arrival_year)
                                {{ $book->arrival_month_name }} {{ $book->arrival_year }}
                            @else
                                -
                            @endif
                        </span>
                    </div>
                    <div class="bg-gray-50 border border-gray-200/80 rounded-2xl p-3 space-y-0.5">
                        <span class="block text-[10px] font-bold uppercase tracking-wider text-gray-400">{{ __('books.shelf_location') }}</span>
                        <span class="font-mono text-xs font-bold text-gray-800 break-words leading-tight block">{{ $book->shelf_location ?? '-' }}</span>
                    </div>
                    <div class="bg-gray-50 border border-gray-200/80 rounded-2xl p-3 space-y-0.5">
                        <span class="block text-[10px] font-bold uppercase tracking-wider text-gray-400">{{ __('books.available_copies') }}</span>
                        <span class="text-xs font-extrabold text-gray-900 leading-tight block">{{ $book->available_copies }} / {{ $book->total_copies }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Content Layout: Readers & Reviews (Left 2 Cols), Add Review (Right 1 Col) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Readers List & Reviews (Left 2 Cols) --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Readers List --}}
            <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="text-base font-extrabold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span>{{ __('books.book_readers') }} ({{ $readers->count() }})</span>
                    </h3>
                </div>

                <div class="divide-y divide-gray-100">
                    @forelse($readers as $loan)
                        <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div>
                                <a href="{{ route('members.show', $loan->member->id ?? 0) }}" class="text-sm font-bold text-gray-900 hover:text-brand-600">
                                    {{ $loan->member->name ?? '-' }}
                                </a>
                                <div class="flex flex-wrap items-center gap-2 text-xs text-gray-400 mt-0.5">
                                    <span class="badge-neutral text-[10px]">{{ __('members.type_' . ($loan->member->member_type ?? 'SD')) }}</span>
                                    @if($loan->status === 'on_site')
                                        <span class="inline-flex items-center gap-1 text-[10px] font-semibold text-purple-600 bg-purple-50 px-2 py-0.5 rounded-full border border-purple-200">📍 Baca di Tempat</span>
                                    @else
                                        <span>{{ __('loans.loan_date') }}: {{ $loan->loan_date?->format('d M Y, H:i') }}</span>
                                        @if($loan->return_date)
                                            <span>· {{ __('loans.return_date') }}: {{ $loan->return_date?->format('d M Y, H:i') }}</span>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <div>
                                @if($loan->status === 'hilang')
                                    <span class="badge-danger text-xs">⚠️ Buku Hilang</span>
                                @elseif($loan->reading_status === 'selesai_dibaca')
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
            <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="text-base font-extrabold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                        <span>{{ __('books.book_reviews') }} ({{ $book->reviews->count() }})</span>
                    </h3>
                </div>

                <div class="space-y-3">
                    @forelse($book->reviews as $review)
                        <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 space-y-1.5">
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

        {{-- Add Review Form (Right 1 Col) --}}
        <div class="space-y-6">
            <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow-sm space-y-4">
                <h3 class="text-base font-extrabold text-gray-900 border-b border-gray-100 pb-3">
                    {{ __('books.add_review') }}
                </h3>

                <form wire:submit.prevent="addReview" class="space-y-4">
                    {{-- SEARCHABLE MEMBER COMBOBOX --}}
                    <div class="relative" x-data="{ open: true }">
                        <label class="form-label">{{ __('books.select_member_for_review') }}</label>

                        @if($selectedMemberId && $selectedMemberText)
                            <div class="flex items-center justify-between p-3 rounded-xl border border-brand-300 bg-brand-50/60">
                                <div class="flex items-center gap-2 min-w-0">
                                    <svg class="w-5 h-5 text-brand-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span class="text-xs font-bold text-gray-900 truncate">{{ $selectedMemberText }}</span>
                                </div>
                                <button type="button" wire:click="clearMember" class="p-1 rounded-lg text-gray-400 hover:text-red-600 hover:bg-white transition-all flex-shrink-0" title="Ganti Anggota">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        @else
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                <input wire:model.live.debounce.300ms="memberSearch"
                                       @focus="open = true"
                                       type="text"
                                       placeholder="Ketik nama, no. anggota, atau email..."
                                       class="form-input pl-10 text-xs">
                            </div>

                            @if(strlen(trim($memberSearch)) >= 1)
                                <div x-show="open" @click.outside="open = false" class="absolute left-0 right-0 top-full mt-1.5 z-30 max-h-60 overflow-y-auto bg-white rounded-xl border border-gray-200 shadow-xl divide-y divide-gray-100">
                                    @forelse($members as $m)
                                        <div wire:click="selectMember({{ $m->id }}, '{{ addslashes($m->name) }}', '{{ $m->member_number }}')"
                                             @click="open = false"
                                             class="p-2.5 hover:bg-brand-50 cursor-pointer transition-colors flex items-center justify-between">
                                            <div>
                                                <p class="text-xs font-bold text-gray-900 leading-tight">{{ $m->name }}</p>
                                                <p class="text-[10px] font-mono text-brand-600 font-bold mt-0.5">{{ $m->member_number }}</p>
                                            </div>
                                            <span class="badge-neutral text-[9px]">{{ __('members.type_' . $m->member_type) }}</span>
                                        </div>
                                    @empty
                                        <div class="p-3 text-center text-xs text-gray-400">
                                            Tidak ada anggota aktif yang cocok dengan "{{ $memberSearch }}"
                                        </div>
                                    @endforelse
                                </div>
                            @endif
                        @endif
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
                        <textarea wire:model="comment" rows="4" class="form-input" placeholder="Tuliskan komentar atau ulasan buku..."></textarea>
                        @error('comment') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="btn-primary w-full justify-center">{{ __('books.save_review') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
