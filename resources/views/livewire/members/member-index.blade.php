<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-black text-gray-900">{{ __('nav.members') }}</h1>
            <p class="text-sm text-gray-400 mt-0.5">Daftar anggota terdaftar, tipe keanggotaan, dan riwayat peminjaman</p>
        </div>
        @can('create', App\Models\Member::class)
            <button @click="$dispatch('openMemberModal')" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                {{ __('members.add_member') }}
            </button>
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
    <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm flex flex-col md:flex-row gap-3">
        <div class="flex-1 relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text"
                   placeholder="{{ __('members.search_placeholder') }}" class="form-input pl-10">
        </div>
        <div class="w-full md:w-52">
            <select wire:model.live="type" class="form-select">
                <option value="">{{ __('members.all_types') }}</option>
                <option value="SD">{{ __('members.type_SD') }}</option>
                <option value="SMP">{{ __('members.type_SMP') }}</option>
                <option value="SMA">{{ __('members.type_SMA') }}</option>
                <option value="Guru">{{ __('members.type_Guru') }}</option>
                <option value="Mahasiswa">{{ __('members.type_Mahasiswa') }}</option>
                <option value="Lainnya">{{ __('members.type_Lainnya') }}</option>
            </select>
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
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-left">{{ __('members.phone') }}</th>
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-left">{{ __('members.member_type') }}</th>
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
                                <p class="text-xs text-gray-400 mt-0.5">{{ $member->email }}</p>
                            </td>
                            <td class="py-3.5 px-4 text-xs font-mono text-gray-500">{{ $member->phone ?? '-' }}</td>
                            <td class="py-3.5 px-4">
                                <span class="badge-neutral">{{ __('members.type_' . $member->member_type) }}</span>
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
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold text-xs border border-blue-200 transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        {{ __('common.detail') }}
                                    </a>
                                    @can('update', $member)
                                        <button @click="$dispatch('openMemberModal', { id: {{ $member->id }} })"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-brand-50 hover:bg-brand-100 text-brand-700 font-semibold text-xs border border-brand-200 transition-all">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            {{ __('common.edit') }}
                                        </button>
                                    @endcan
                                    @can('delete', $member)
                                        <button onclick="confirm('{{ __('members.delete_confirm') }}') || event.stopImmediatePropagation()"
                                                wire:click="deleteMember({{ $member->id }})"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-700 font-semibold text-xs border border-red-200 transition-all">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            {{ __('common.delete') }}
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
