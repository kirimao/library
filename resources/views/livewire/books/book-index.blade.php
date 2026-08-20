<div class="space-y-5">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-black text-gray-900">{{ __('nav.books') }}</h1>
            <p class="text-sm text-gray-400 mt-0.5">{{ __('books.subtitle') }}</p>
        </div>
        <div class="flex items-center gap-3">
            @can('create', App\Models\Category::class)
                <a href="{{ route('categories.index') }}" class="px-4 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-sm transition-all">
                    {{ __('books.manage_categories') }}
                </a>
            @endcan
            @can('create', App\Models\Genre::class)
                <a href="{{ route('genres.index') }}" class="px-4 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-sm transition-all">
                    {{ __('books.manage_genres') }}
                </a>
            @endcan
            @can('create', App\Models\Book::class)
                <a href="{{ route('books.import') }}" class="px-4 py-2.5 rounded-xl bg-purple-50 hover:bg-purple-100 text-purple-700 border border-purple-200 font-bold text-sm inline-flex items-center gap-1.5 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    <span>Impor CSV</span>
                </a>
                <button @click="$dispatch('openBookModal')" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('books.add_book') }}
                </button>
            @endcan
        </div>
    </div>

    {{-- Flash Messages --}}
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

    {{-- Search & Filter --}}
    <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm space-y-3">
        {{-- Search Bar & Page Size Selector --}}
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
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

        {{-- Dropdowns Filter (Baris Bawah Horizontal Samping-sampingan) --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <div>
                <select wire:model.live="categoryId" class="form-select w-full">
                    <option value="">{{ __('common.all_categories') ?? 'Semua Kategori' }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select wire:model.live="genreId" class="form-select w-full">
                    <option value="">{{ __('books.all_genres') }}</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select wire:model.live="arrivalStatus" class="form-select w-full">
                    <option value="">{{ __('books.all_arrival_statuses') }}</option>
                    <option value="baru">{{ __('books.new_arrival') }} (>= 2025)</option>
                    <option value="lama">{{ __('books.old_arrival') }} (< 2025)</option>
                </select>
            </div>
            <div>
                <select wire:model.live="arrivalYear" class="form-select w-full">
                    <option value="">{{ __('books.all_arrival_years') }}</option>
                    @foreach($availableArrivalYears as $y)
                        <option value="{{ $y }}">📅 {{ __('common.year') ?? 'Tahun' }} {{ $y }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="table-head">
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-left">{{ __('books.title') }} & {{ __('books.author') }}</th>
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-left">Genre</th>
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-left">{{ __('books.category') }}</th>
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-center">{{ __('books.available_copies') }}</th>
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-left">{{ __('books.shelf_location') }}</th>
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-right">{{ __('common.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($books as $book)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-14 rounded-lg bg-slate-100 border border-slate-200 overflow-hidden flex-shrink-0 flex items-center justify-center text-slate-400 relative">
                                        @if(!empty($book->cover_thumbnail))
                                            <img src="{{ asset('storage/' . $book->cover_thumbnail) }}" alt="{{ $book->title }}" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <div class="hidden w-full h-full items-center justify-center bg-slate-100">
                                                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                </svg>
                                            </div>
                                        @elseif(!empty($book->cover_image))
                                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <div class="hidden w-full h-full items-center justify-center bg-slate-100">
                                                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                </svg>
                                            </div>
                                        @else
                                            <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <a href="{{ route('books.show', $book->id) }}" class="text-sm font-bold text-gray-900 hover:text-brand-600 leading-tight">
                                                {{ $book->title }} ↗
                                            </a>
                                            @if($book->isNewArrival())
                                                <span class="inline-flex items-center gap-0.5 px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 border border-emerald-300 flex-shrink-0">
                                                    {{ __('books.new_arrival') }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-0.5 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-gray-100 text-gray-600 border border-gray-200 flex-shrink-0">
                                                    {{ __('books.old_arrival') }}
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-400 mt-0.5">
                                            {{ $book->author }}
                                            @if($book->publisher) · <span>{{ $book->publisher }} ({{ $book->year }})</span>@endif
                                            @if($book->arrival_month || $book->arrival_year)
                                                · <span class="text-brand-700 font-medium">{{ __('books.arrival_info') }}: {{ $book->arrival_month_name }} {{ $book->arrival_year }}</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($book->genres as $g)
                                        <span class="badge-neutral text-[10px] py-0.5 px-2">{{ $g->name }}</span>
                                    @empty
                                        <span class="text-xs text-gray-300 italic">—</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="badge-neutral">{{ $book->category->name ?? '-' }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($book->available_copies > 0)
                                    <span class="badge-success">{{ $book->available_copies }}/{{ $book->total_copies }}</span>
                                @else
                                    <span class="badge-danger">0/{{ $book->total_copies }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 font-mono text-xs text-gray-400">{{ $book->shelf_location ?? '-' }}</td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('books.show', $book->id) }}" title="Lihat Detail Buku"
                                       class="px-3 py-1.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs inline-flex items-center gap-1.5 shadow-sm transition-all active:scale-95">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <span>{{ __('common.detail') }}</span>
                                    </a>
                                    @can('update', $book)
                                        <button @click="$dispatch('openBookModal', { id: {{ $book->id }} })"
                                                title="{{ __('common.edit') }}"
                                                class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs inline-flex items-center gap-1.5 shadow-sm transition-all active:scale-95">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            <span>{{ __('common.edit') }}</span>
                                        </button>
                                    @endcan
                                    @can('delete', $book)
                                        <button onclick="confirm('{{ __('books.delete_confirm') }}') || event.stopImmediatePropagation()"
                                                wire:click="deleteBook({{ $book->id }})"
                                                title="{{ __('common.delete') }}"
                                                class="px-3 py-1.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs inline-flex items-center gap-1.5 shadow-sm transition-all active:scale-95">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            <span>{{ __('common.delete') }}</span>
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-400 text-sm">{{ __('common.no_data') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-gray-100 bg-gray-50">
            {{ $books->links() }}
        </div>
    </div>

    <livewire:books.book-form />
</div>
