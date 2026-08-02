<div class="max-w-2xl mx-auto space-y-5">
    <div>
        <h1 class="text-xl font-black text-gray-900">{{ __('loans.issue_loan') }}</h1>
        <p class="text-sm text-gray-400 mt-0.5">Catat transaksi peminjaman buku baru</p>
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

    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
        <form wire:submit.prevent="submitLoan" class="space-y-5">
            
            {{-- SEARCHABLE MEMBER COMBOBOX --}}
            <div class="relative" x-data="{ open: true }">
                <label class="form-label">{{ __('loans.member') }} *</label>

                @if($member_id && $selectedMemberText)
                    <div class="flex items-center justify-between p-3 rounded-xl border border-brand-300 bg-brand-50/60">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-brand-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="text-sm font-bold text-gray-900">{{ $selectedMemberText }}</span>
                        </div>
                        <button type="button" wire:click="clearMember" class="p-1 rounded-lg text-gray-400 hover:text-red-600 hover:bg-white transition-all" title="Ganti Anggota">
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
                               class="form-input pl-10">
                    </div>

                    @if(strlen(trim($memberSearch)) >= 1)
                        <div x-show="open" @click.outside="open = false" class="absolute left-0 right-0 top-full mt-1.5 z-30 max-h-60 overflow-y-auto bg-white rounded-xl border border-gray-200 shadow-xl divide-y divide-gray-100">
                            @forelse($members as $m)
                                <div wire:click="selectMember({{ $m->id }}, '{{ addslashes($m->name) }}', '{{ $m->member_number }}')"
                                     @click="open = false"
                                     class="p-3 hover:bg-brand-50 cursor-pointer transition-colors flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-bold text-gray-900 leading-tight">{{ $m->name }}</p>
                                        <p class="text-xs font-mono text-brand-600 font-bold mt-0.5">{{ $m->member_number }}</p>
                                    </div>
                                    <span class="badge-neutral text-[10px]">{{ __('members.type_' . $m->member_type) }}</span>
                                </div>
                            @empty
                                <div class="p-4 text-center text-xs text-gray-400">
                                    Tidak ada anggota aktif yang cocok dengan "{{ $memberSearch }}"
                                </div>
                            @endforelse
                        </div>
                    @endif
                @endif
                @error('member_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- SEARCHABLE BOOK COMBOBOX --}}
            <div class="relative" x-data="{ open: true }">
                <label class="form-label">{{ __('loans.book') }} *</label>

                @if($book_id && $selectedBookText)
                    <div class="flex items-center justify-between p-3 rounded-xl border border-brand-300 bg-brand-50/60">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-brand-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span class="text-sm font-bold text-gray-900">{{ $selectedBookText }}</span>
                        </div>
                        <button type="button" wire:click="clearBook" class="p-1 rounded-lg text-gray-400 hover:text-red-600 hover:bg-white transition-all" title="Ganti Buku">
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
                        <input wire:model.live.debounce.300ms="bookSearch"
                               @focus="open = true"
                               type="text"
                               placeholder="Ketik judul buku, penulis, atau ISBN..."
                               class="form-input pl-10">
                    </div>

                    @if(strlen(trim($bookSearch)) >= 1)
                        <div x-show="open" @click.outside="open = false" class="absolute left-0 right-0 top-full mt-1.5 z-30 max-h-60 overflow-y-auto bg-white rounded-xl border border-gray-200 shadow-xl divide-y divide-gray-100">
                            @forelse($books as $b)
                                @php $isAvailable = $b->available_copies > 0; @endphp
                                <div @if($isAvailable)
                                         wire:click="selectBook({{ $b->id }}, '{{ addslashes($b->title) }}', {{ $b->available_copies }}, {{ $b->total_copies }})"
                                         @click="open = false"
                                     @endif
                                     class="p-3 flex items-center justify-between {{ $isAvailable ? 'hover:bg-brand-50 cursor-pointer' : 'bg-gray-50 opacity-60 cursor-not-allowed' }} transition-colors">
                                    <div>
                                        <p class="text-sm font-bold text-gray-900 leading-tight">{{ $b->title }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $b->author }} · ISBN: {{ $b->isbn }}</p>
                                    </div>
                                    <div class="text-right flex-shrink-0 ml-3">
                                        @if($isAvailable)
                                            <span class="badge-success text-xs">Stok: {{ $b->available_copies }}/{{ $b->total_copies }}</span>
                                        @else
                                            <span class="badge-danger text-xs">HABIS (0/{{ $b->total_copies }})</span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-center text-xs text-gray-400">
                                    Tidak ada buku yang cocok dengan "{{ $bookSearch }}"
                                </div>
                            @endforelse
                        </div>
                    @endif
                @endif
                @error('book_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- DATE PICKER FOR DUE DATE --}}
            <div>
                <label class="form-label">{{ __('loans.due_date') }} *</label>
                <input wire:model="due_date"
                       type="date"
                       min="{{ date('Y-m-d') }}"
                       class="form-input">
                <p class="text-xs text-gray-400 mt-1">Pilih tanggal jatuh tempo pengembalian buku dari kalender.</p>
                @error('due_date') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-100">
                <a href="{{ route('dashboard') }}" class="px-4 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-sm transition-all">
                    {{ __('common.cancel') }}
                </a>
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                    {{ __('loans.issue_loan') }}
                </button>
            </div>
        </form>
    </div>
</div>
