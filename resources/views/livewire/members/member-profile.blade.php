<div class="space-y-6">
    {{-- Back button --}}
    <div class="flex items-center justify-between gap-4">
        <a href="{{ route('members.index') }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs transition-all">
            {{ __('members.back_to_list') }}
        </a>
    </div>

    {{-- Profile Header Card --}}
    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-brand-100 border border-brand-200 text-brand-700 flex items-center justify-center font-black text-2xl uppercase">
                {{ substr($member->name, 0, 2) }}
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h1 class="text-xl font-black text-gray-900">{{ $member->name }}</h1>
                    <span class="badge-neutral text-xs font-bold">{{ __('members.type_' . $member->member_type) }}</span>
                    @if($member->status === 'active')
                        <span class="badge-success text-xs">{{ __('common.active') }}</span>
                    @else
                        <span class="badge-danger text-xs">{{ __('common.inactive') }}</span>
                    @endif
                </div>
                <p class="text-xs font-mono text-brand-600 font-bold mt-1">{{ $member->member_number }} · {{ $member->email }}</p>
            </div>
        </div>

        <div class="bg-brand-50 border border-brand-200 rounded-2xl p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-brand-600 text-white flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
            </div>
            <div>
                <span class="block text-[10px] font-bold uppercase tracking-wider text-brand-600">{{ __('members.favorite_genre') }}</span>
                <span class="text-sm font-black text-brand-900">
                    {{ $favoriteGenre->name ?? '-' }}
                </span>
            </div>
        </div>
    </div>

    {{-- Reading History Table --}}
    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm space-y-4 p-5">
        <h3 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
            <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            {{ __('members.reading_history') }} ({{ $readingHistory->count() }})
        </h3>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr>
                        <th class="py-3 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-left">{{ __('books.title') }} & {{ __('books.genres') }}</th>
                        <th class="py-3 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-left">{{ __('loans.loan_date') }}</th>
                        <th class="py-3 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-left">{{ __('loans.return_date') }} / {{ __('loans.due_date') }}</th>
                        <th class="py-3 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-center">{{ __('loans.reading_status') }}</th>
                        <th class="py-3 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-left">{{ __('books.review_comment') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($readingHistory as $loan)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3.5 px-4">
                                <a href="{{ route('books.show', $loan->book->id ?? 0) }}" class="text-sm font-bold text-gray-900 hover:text-brand-600 leading-tight">
                                    {{ $loan->book->title ?? '-' }} ↗
                                </a>
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @foreach($loan->book->genres ?? [] as $g)
                                        <span class="badge-neutral text-[10px] py-0.5 px-1.5">{{ $g->name }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-xs text-gray-500">{{ $loan->loan_date->format('d M Y') }}</td>
                            <td class="py-3.5 px-4 text-xs text-gray-500">
                                @if($loan->return_date)
                                    <span>{{ $loan->return_date->format('d M Y') }}</span>
                                @else
                                    <span class="text-amber-600 font-bold">Due: {{ $loan->due_date->format('d M Y') }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($loan->reading_status === 'selesai_dibaca')
                                    <span class="badge-success text-xs">{{ __('loans.status_selesai_dibaca') }}</span>
                                @elseif($loan->reading_status === 'belum_selesai')
                                    <span class="badge-warning text-xs">{{ __('loans.status_belum_selesai') }}</span>
                                @else
                                    <span class="badge-neutral text-xs">{{ __('loans.status_sedang_dibaca') }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-xs text-gray-600 italic">
                                @if($loan->review)
                                    "{{ $loan->review->comment }}"
                                @else
                                    <span class="text-gray-300">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-400 text-sm">{{ __('members.no_history') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
