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
                            <label class="form-label">{{ __('books.isbn') }} *</label>
                            <input wire:model="isbn" type="text" class="form-input font-mono">
                            @error('isbn') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="form-label">{{ __('books.category') }} *</label>
                            <select wire:model="category_id" class="form-select">
                                <option value="">-- Pilih Kategori --</option>
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

                    {{-- Multi-select Genre --}}
                    <div>
                        <label class="form-label">{{ __('books.select_genres') }}</label>
                        <div class="flex flex-wrap gap-1.5 max-h-28 overflow-y-auto p-2 rounded-xl border border-gray-200 bg-gray-50/50">
                            @forelse($allGenres as $genre)
                                <label class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg border bg-white text-xs font-semibold cursor-pointer hover:border-brand-500 transition-colors {{ in_array($genre->id, $genre_ids) ? 'border-brand-500 text-brand-700 bg-brand-50' : 'border-gray-200 text-gray-700' }}">
                                    <input type="checkbox" wire:model="genre_ids" value="{{ $genre->id }}" class="rounded text-brand-600 focus:ring-brand-500">
                                    {{ $genre->name }}
                                </label>
                            @empty
                                <span class="text-xs text-gray-400">Belum ada genre. Tambahkan di menu Kelola Genre.</span>
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
