<div>
    @if($isOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" @click="$wire.closeModal()"></div>
            <div class="relative bg-white rounded-3xl border border-gray-100 shadow-2xl p-6 w-full my-auto z-10" style="max-width: 480px; width: 100%; margin-left: auto; margin-right: auto;">

                {{-- Modal Header --}}
                <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-100">
                    <h3 class="text-base font-bold text-gray-900">
                        {{ $bookId ? __('books.edit_book') : __('books.add_book') }}
                    </h3>
                    <button wire:click="closeModal" class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="save" class="space-y-4">
                    <div>
                        <label class="form-label">{{ __('books.title') }} *</label>
                        <input wire:model="title" type="text" class="form-input">
                        @error('title') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="form-label">{{ __('books.author') }} *</label>
                            <input wire:model="author" type="text" class="form-input">
                            @error('author') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">{{ __('books.isbn') }} (Opsional)</label>
                            <input wire:model="isbn" type="text" class="form-input font-mono">
                            @error('isbn') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="form-label">{{ __('books.category') }} *</label>
                            <select wire:model="category_id" class="form-select">
                                <option value="">-- {{ __('books.select_category') }} --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">{{ __('books.total_copies') }} *</label>
                            <input wire:model="total_copies" type="number" min="1" class="form-input">
                            @error('total_copies') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Multi-select Genre with Search --}}
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label class="form-label mb-0">{{ __('books.select_genres') }}</label>
                            @if(count($genre_ids) > 0)
                                <span class="text-[10px] font-black text-brand-700 bg-brand-50 px-2 py-0.5 rounded-full border border-brand-200">
                                    {{ count($genre_ids) }} {{ __('books.selected') }}
                                </span>
                            @endif
                        </div>

                        {{-- Search Input for Genre --}}
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input wire:model.live.debounce.150ms="genreSearch" type="text"
                                   placeholder="{{ __('books.search_genre') }}"
                                   class="w-full text-xs pl-8 pr-7 py-1.5 rounded-xl border border-gray-200 bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all">
                            @if($genreSearch)
                                <button type="button" wire:click="$set('genreSearch', '')" class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-gray-400 hover:text-gray-600">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            @endif
                        </div>

                        <div class="flex flex-wrap gap-1.5 max-h-28 overflow-y-auto p-2 rounded-xl border border-gray-200 bg-gray-50/50">
                            @forelse($allGenres as $genre)
                                <label class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg border bg-white text-xs font-semibold cursor-pointer hover:border-brand-500 transition-colors {{ in_array($genre->id, $genre_ids) ? 'border-brand-500 text-brand-700 bg-brand-50' : 'border-gray-200 text-gray-700' }}">
                                    <input type="checkbox" wire:model="genre_ids" value="{{ $genre->id }}" class="rounded text-brand-600 focus:ring-brand-500">
                                    {{ $genre->name }}
                                </label>
                            @empty
                                <span class="text-xs text-gray-400 py-1 px-1">
                                    {{ $genreSearch ? __('common.no_data') : __('books.no_genres_available') }}
                                </span>
                            @endforelse
                        </div>
                        @error('genre_ids') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="form-label">{{ __('books.publisher') }}</label>
                            <input wire:model="publisher" type="text" class="form-input">
                            @error('publisher') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">{{ __('books.year') }}</label>
                            <input wire:model="year" type="number" placeholder="{{ date('Y') }}" class="form-input">
                            @error('year') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">{{ __('books.shelf_location') }}</label>
                            <input wire:model="shelf_location" type="text" placeholder="A-01" class="form-input font-mono">
                            @error('shelf_location') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Harga & Jenis Cover --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="form-label">{{ __('books.price') }} (Rp)</label>
                            <input wire:model="price" type="number" min="0" step="500" placeholder="0" class="form-input font-mono">
                            @error('price') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">{{ __('books.cover_type') }}</label>
                            <select wire:model="cover_type" class="form-select">
                                <option value="">-- Pilih Jenis Cover --</option>
                                <option value="Paperback">Paperback</option>
                                <option value="Hardcover">Hardcover</option>
                                <option value="Softcover">Softcover</option>
                                <option value="Spiral">Spiral / Ring</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            @error('cover_type') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Waktu Kedatangan Buku --}}
                    <div class="p-3.5 bg-brand-50/60 rounded-2xl border border-brand-200/80 space-y-2.5">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-extrabold text-brand-900 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>{{ __('books.arrival_header') }}</span>
                            </label>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-white text-brand-700 border border-brand-200">{{ __('books.month_and_year') }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-[11px] font-semibold text-gray-600 block mb-1">{{ __('books.arrival_month') }}</label>
                                <select wire:model="arrival_month" class="form-select text-xs">
                                    <option value="">-- {{ __('books.select_month') }} --</option>
                                    @for($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}">{{ __('common.months.' . $m) }}</option>
                                    @endfor
                                </select>
                                @error('arrival_month') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="text-[11px] font-semibold text-gray-600 block mb-1">{{ __('books.arrival_year') }}</label>
                                <select wire:model="arrival_year" class="form-select text-xs">
                                    <option value="">-- {{ __('books.select_year') }} --</option>
                                    @for($y = date('Y'); $y >= 2000; $y--)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                    @endfor
                                </select>
                                @error('arrival_year') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Upload Gambar Cover Buku --}}
                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200/80 space-y-2">
                        <label class="form-label text-xs font-extrabold text-slate-800 flex items-center justify-between">
                            <span>Gambar Cover Buku (Maks. 5 MB)</span>
                            <span class="text-[10px] text-slate-400 font-normal">Format: JPG, PNG, WebP · Dikompres otomatis</span>
                        </label>

                        <div class="flex items-center gap-3">
                            <div class="w-16 h-20 rounded-xl bg-slate-200 border border-slate-300 overflow-hidden flex-shrink-0 relative flex items-center justify-center text-slate-400">
                                @if ($cover_image_file)
                                    <img src="{{ $cover_image_file->temporaryUrl() }}" class="w-full h-full object-cover">
                                @elseif ($currentCoverThumbnail)
                                    <img src="{{ asset('storage/' . $currentCoverThumbnail) }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                @endif
                                <div wire:loading wire:target="cover_image_file" class="absolute inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center text-white text-[10px] font-bold">
                                    ⏳ Proses...
                                </div>
                            </div>
                            <div class="flex-1 min-w-0 space-y-1.5">
                                <input type="file" wire:model="cover_image_file" accept="image/jpeg,image/png,image/jpg,image/webp"
                                       class="block w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 transition-all cursor-pointer">
                                @error('cover_image_file')
                                    <p class="text-xs font-bold text-red-600">⚠ {{ $message }}</p>
                                @else
                                    @if($cover_image_file)
                                        <p class="text-[11px] text-emerald-700 font-semibold">
                                            ✅ Gambar dipilih ({{ round($cover_image_file->getSize() / 1024) }} KB) — akan dikompres otomatis saat disimpan
                                        </p>
                                    @else
                                        <p class="text-[10px] text-slate-400">Kosongkan jika tidak ingin mengubah gambar cover.</p>
                                    @endif
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <button type="button" wire:click="closeModal" class="px-4 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-sm transition-all">
                            {{ __('common.cancel') }}
                        </button>
                        <button type="submit" class="btn-primary">{{ __('common.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
