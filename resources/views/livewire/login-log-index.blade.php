<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-black text-gray-900">Log Aktivitas Login</h1>
            <p class="text-sm text-gray-400 mt-0.5">Riwayat semua pengguna yang berhasil masuk ke sistem</p>
        </div>
    </div>

    @if(session()->has('success'))
        <div class="alert-success">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Search & Page Size Selector --}}
    <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text"
                   placeholder="Cari nama, email, role, atau IP address..."
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
                @if($canShowAll)
                    <option value="all">{{ __('common.all') }}</option>
                @endif
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr>
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-left">Pengguna</th>
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-left">Role</th>
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-left">Waktu Login</th>
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-left">IP Address</th>
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-left">Browser / Device</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full flex items-center justify-center font-bold text-white text-xs flex-shrink-0"
                                         style="background-color: #12a24a;">
                                        {{ strtoupper(substr($log->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">{{ $log->name ?? '-' }}</p>
                                        <p class="text-xs text-gray-400">{{ $log->email ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($log->role === 'admin')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-purple-100 text-purple-700">Administrator</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-brand-100 text-brand-700">Pustakawan</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <p class="text-sm font-semibold text-gray-900">{{ $log->created_at->format('d M Y') }}</p>
                                <p class="text-xs text-gray-400 font-mono">{{ $log->created_at->format('H:i:s') }}</p>
                                <p class="text-[11px] text-gray-300 mt-0.5">{{ $log->created_at->diffForHumans() }}</p>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-mono text-xs text-gray-700 bg-gray-100 px-2 py-0.5 rounded">{{ $log->ip_address ?? '-' }}</span>
                            </td>
                            <td class="py-3.5 px-4 max-w-xs">
                                <p class="text-xs text-gray-500 truncate" title="{{ $log->user_agent }}">
                                    {{ $log->user_agent ? Str::limit($log->user_agent, 60) : '-' }}
                                </p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-400 text-sm">Belum ada data log login.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t border-gray-100 bg-gray-50">
            {{ $logs->links() }}
        </div>
    </div>
</div>
