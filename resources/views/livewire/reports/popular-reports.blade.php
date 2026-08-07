<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-black text-gray-900">{{ __('reports.title') }}</h1>
            <p class="text-sm text-gray-400 mt-0.5">{{ __('reports.subtitle') }}</p>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm flex flex-col md:flex-row gap-4 items-center justify-between">
        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-1">{{ __('reports.filter_member_type') }}</label>
                <select wire:model.live="selectedMemberType" class="form-select text-xs">
                    <option value="">{{ __('reports.all_member_types') }}</option>
                    <option value="SD">{{ __('members.type_SD') }}</option>
                    <option value="SMP">{{ __('members.type_SMP') }}</option>
                    <option value="SMA">{{ __('members.type_SMA') }}</option>
                    <option value="Guru">{{ __('members.type_Guru') }}</option>
                    <option value="Mahasiswa">{{ __('members.type_Mahasiswa') }}</option>
                    <option value="Lainnya">{{ __('members.type_Lainnya') }}</option>
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-1">{{ __('reports.filter_genre') }}</label>
                <select wire:model.live="selectedGenreId" class="form-select text-xs">
                    <option value="">{{ __('reports.all_genres') }}</option>
                    @foreach($genres as $g)
                        <option value="{{ $g->id }}">{{ $g->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @if($selectedMemberType || $selectedGenreId)
            <button wire:click="$set('selectedMemberType', null); $set('selectedGenreId', null)"
                    class="text-xs font-bold text-gray-500 hover:text-gray-900 underline">
                {{ __('reports.reset_filter') }}
            </button>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Popular Genres Card --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    {{ __('reports.popular_genres_title') }}
                </h3>
            </div>

            <div class="space-y-3">
                @forelse($popularGenres as $index => $genre)
                    <div class="p-3.5 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-7 h-7 rounded-lg bg-brand-100 text-brand-700 font-black text-xs flex items-center justify-center">
                                #{{ $index + 1 }}
                            </span>
                            <span class="text-sm font-bold text-gray-900">{{ $genre->name }}</span>
                        </div>
                        <span class="badge-success text-xs">
                            {{ $genre->loans_count }} {{ __('reports.times_read') }}
                        </span>
                    </div>
                @empty
                    <p class="py-8 text-center text-sm text-gray-400">{{ __('reports.no_data') }}</p>
                @endforelse
            </div>
        </div>

        {{-- Most Read Books Card --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    {{ __('reports.most_read_books_title') }}
                </h3>
            </div>

            <div class="space-y-3">
                @forelse($mostReadBooks as $index => $book)
                    <div class="p-3.5 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 font-black text-xs flex items-center justify-center flex-shrink-0">
                                #{{ $index + 1 }}
                            </span>
                            <div class="w-8 h-11 rounded bg-slate-200 border border-slate-300 overflow-hidden flex-shrink-0 flex items-center justify-center text-slate-400">
                                @if(!empty($book->cover_thumbnail))
                                    <img src="{{ asset('storage/' . $book->cover_thumbnail) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                                @elseif(!empty($book->cover_image))
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <a href="{{ route('books.show', $book->id) }}" class="text-sm font-bold text-gray-900 hover:text-brand-600 leading-tight">
                                    {{ $book->title }} ↗
                                </a>
                                <p class="text-xs text-gray-400">{{ $book->author }}</p>
                            </div>
                        </div>
                        <span class="badge-neutral text-xs font-bold flex-shrink-0">
                            {{ $book->loans_count }} {{ __('reports.times_borrowed') }}
                        </span>
                    </div>
                @empty
                    <p class="py-8 text-center text-sm text-gray-400">{{ __('reports.no_data') }}</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
