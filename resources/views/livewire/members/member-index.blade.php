<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-black text-gray-900">{{ __('nav.members') }}</h1>
            <p class="text-sm text-gray-400 mt-0.5">Daftar anggota terdaftar, tipe keanggotaan, dan riwayat peminjaman</p>
        </div>
        @can('create', App\Models\Member::class)
            <div class="flex items-center gap-3">
                <a href="{{ route('members.promote') }}" class="px-4 py-2.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 font-bold text-sm inline-flex items-center gap-1.5 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    <span>Kenaikan Kelas</span>
                </a>
                <button @click="$dispatch('openMemberModal')" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    {{ __('members.add_member') }}
                </button>
            </div>
        @endcan
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

    {{-- Search & Filter --}}
    <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm space-y-3">
        {{-- Baris Atas: Search Bar & Page Size Selector --}}
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text"
                       placeholder="{{ __('members.search_placeholder') }}" class="form-input pl-10 w-full">
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
                    <option value="all">{{ __('common.all') }}</option>
                </select>
            </div>
        </div>

        {{-- Baris Bawah: Dropdown Filters --}}
        <div class="flex flex-wrap items-center gap-3">
            <div class="w-full sm:w-56">
                <select wire:model.live="type" class="form-select w-full">
                    <option value="">{{ __('members.all_types') }}</option>
                    <option value="SD">{{ __('members.type_SD') }}</option>
                    <option value="SMP">{{ __('members.type_SMP') }}</option>
                    <option value="SMA">{{ __('members.type_SMA') }}</option>
                    <option value="Guru">{{ __('members.type_Guru') }}</option>
                    <option value="Mahasiswa">{{ __('members.type_Mahasiswa') }}</option>
                    <option value="Lainnya">{{ __('members.type_Lainnya') }}</option>
                </select>
            </div>
            <div class="w-full sm:w-48">
                <select wire:model.live="grade" class="form-select w-full">
                    <option value="">Semua Kelas</option>
                    <option value="Kelas 1">Kelas 1</option>
                    <option value="Kelas 2">Kelas 2</option>
                    <option value="Kelas 3">Kelas 3</option>
                    <option value="Kelas 4">Kelas 4</option>
                    <option value="Kelas 5">Kelas 5</option>
                    <option value="Kelas 6">Kelas 6</option>
                    <option value="Kelas 7">Kelas 7</option>
                    <option value="Kelas 8">Kelas 8</option>
                    <option value="Kelas 9">Kelas 9</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr>
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-left">{{ __('members.member_number') }}</th>
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-left">{{ __('members.name') }}</th>
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-left">Tipe</th>
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-left">Kelas</th>
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-center">{{ __('members.status') }}</th>
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-right">{{ __('common.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($members as $member)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3.5 px-4 font-mono text-xs font-bold text-brand-600">
                                <a href="{{ route('members.show', $member->id) }}" class="hover:underline">
                                    {{ $member->member_number }}
                                </a>
                            </td>
                            <td class="py-3.5 px-4">
                                <a href="{{ route('members.show', $member->id) }}" class="text-sm font-bold text-gray-900 hover:text-brand-600 leading-tight">
                                    {{ $member->name }} ↗
                                </a>
                                @if($member->email)
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $member->email }}</p>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="badge-neutral">{{ __('members.type_' . $member->member_type) }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($member->grade)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">{{ $member->grade }}</span>
                                @else
                                    <span class="text-gray-300 text-xs">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($member->status === 'active')
                                    <span class="badge-success">{{ __('common.active') }}</span>
                                @else
                                    <span class="badge-danger">{{ __('common.inactive') }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('members.show', $member->id) }}" title="Lihat Profil & Riwayat"
                                       class="px-3 py-1.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs inline-flex items-center gap-1.5 shadow-sm transition-all active:scale-95">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span>{{ __('common.detail') }}</span>
                                    </a>
                                    @can('update', $member)
                                        <button @click="$dispatch('openMemberModal', { id: {{ $member->id }} })"
                                                class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs inline-flex items-center gap-1.5 shadow-sm transition-all active:scale-95">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            <span>{{ __('common.edit') }}</span>
                                        </button>
                                    @endcan
                                    @can('delete', $member)
                                        <button onclick="confirm('{{ __('members.delete_confirm') }}') || event.stopImmediatePropagation()"
                                                wire:click="deleteMember({{ $member->id }})"
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
            {{ $members->links() }}
        </div>
    </div>

    <livewire:members.member-form />
</div>
