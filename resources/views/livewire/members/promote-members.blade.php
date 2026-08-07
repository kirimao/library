<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-black text-gray-900">Kenaikan Kelas Massal & Penyesuaian Jenjang</h1>
            <p class="text-xs text-gray-500 mt-1">Kelola proses kenaikan jenjang kelas secara otomatis untuk semua siswa atau lakukan penyesuaian manual per anggota.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('members.index') }}" class="px-3.5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs transition-all">
                ← Kembali ke Daftar Anggota
            </a>
            <button onclick="confirm('Apakah Anda yakin ingin memproses kenaikan kelas untuk SELURUH siswa aktif? (Proses ini akan menaikkan tingkat SD/SMP/SMA dan meluluskan siswa tingkat akhir)') && @this.call('promoteAll')"
                    class="btn-primary flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                <span>Jalankan Kenaikan Kelas Massal</span>
            </button>
        </div>
    </div>

    @if($lastPromotionDate)
        <div class="p-3.5 bg-blue-50 border border-blue-200 rounded-2xl flex items-center justify-between text-xs text-blue-900">
            <div class="flex items-center gap-2 font-semibold">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Terakhir kali kenaikan kelas massal dijalankan:</span>
            </div>
            <span class="font-bold font-mono bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-[11px]">{{ \Illuminate\Support\Carbon::parse($lastPromotionDate)->format('d M Y, H:i:s') }}</span>
        </div>
    @endif

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

    {{-- Filter & Search --}}
    <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="relative flex-1 w-full">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama atau nomor anggota..." class="form-input w-full pl-10 text-xs">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>
        <div class="w-full sm:w-48">
            <select wire:model.live="filterType" class="form-select text-xs w-full">
                <option value="">Semua Tipe/Jenjang</option>
                <option value="SD">SD</option>
                <option value="SMP">SMP</option>
                <option value="SMA">SMA</option>
                <option value="Guru">Guru</option>
                <option value="Lainnya">Lainnya / Alumni</option>
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="table-head">
                        <th class="py-3 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-left">Anggota</th>
                        <th class="py-3 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-left">Jenjang</th>
                        <th class="py-3 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-left">Kelas / Tingkat</th>
                        <th class="py-3 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-center">Status</th>
                        <th class="py-3 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($members as $m)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-4">
                                <div class="font-bold text-gray-900 text-sm">{{ $m->name }}</div>
                                <div class="text-xs text-gray-400 font-mono">{{ $m->member_number }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="badge-neutral text-xs font-bold">{{ $m->member_type }}</span>
                            </td>
                            <td class="py-3 px-4 text-xs font-bold text-gray-700">
                                {{ $m->grade ?? '-' }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                @if($m->status === 'active')
                                    <span class="badge-success text-xs">Aktif</span>
                                @else
                                    <span class="badge-neutral text-xs">Non-Aktif / Alumni</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right">
                                <button wire:click="openAdjustModal({{ $m->id }})" class="px-3 py-1 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs transition-all">
                                    Edit Kelas Manual
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-sm text-gray-400">Tidak ada data anggota ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-gray-100 bg-gray-50">
            {{ $members->links() }}
        </div>
    </div>

    {{-- Manual Grade Adjustment Modal --}}
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-5 border border-gray-100">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="text-base font-extrabold text-gray-900">Edit Jenjang / Kelas Manual</h3>
                    <button wire:click="closeAdjustModal" class="text-gray-400 hover:text-gray-600">✕</button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="form-label">Nama Anggota</label>
                        <input type="text" value="{{ $selectedMemberName }}" disabled class="form-input bg-gray-50 font-bold text-gray-700">
                    </div>

                    <div>
                        <label class="form-label">Tipe / Jenjang Sekolah</label>
                        <select wire:model="editMemberType" class="form-select">
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="SMA">SMA</option>
                            <option value="Guru">Guru</option>
                            <option value="Lainnya">Lainnya / Alumni</option>
                        </select>
                    </div>

                    <div>
                        <label class="form-label">Kelas / Tingkat</label>
                        <input type="text" wire:model="editGrade" placeholder="Contoh: Kelas 5 / Alumni" class="form-input">
                    </div>

                    <div>
                        <label class="form-label">Status Anggota</label>
                        <select wire:model="editStatus" class="form-select">
                            <option value="active">Aktif</option>
                            <option value="inactive">Non-Aktif / Alumni</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-3 border-t border-gray-100">
                    <button wire:click="closeAdjustModal" class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs">Batal</button>
                    <button wire:click="saveAdjust" class="btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    @endif
</div>
