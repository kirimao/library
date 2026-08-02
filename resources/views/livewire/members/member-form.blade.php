<div>
    @if($isOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto" role="dialog" aria-modal="true"
             x-data="{ tab: 'profile' }">
            <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" @click="$wire.closeModal()"></div>
            <div class="relative bg-white rounded-3xl border border-gray-100 shadow-2xl p-6 w-full my-auto z-10" style="max-width: 480px; width: 100%; margin-left: auto; margin-right: auto;">

                {{-- Header --}}
                <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <h3 class="text-base font-bold text-gray-900">
                            {{ $memberId ? __('members.edit_member') : __('members.add_member') }}
                        </h3>
                        @if($memberId)
                            <div class="flex bg-gray-100 rounded-lg p-1 text-xs">
                                <button @click="tab = 'profile'" :class="tab === 'profile' ? 'bg-brand-500 text-white font-bold shadow-sm' : 'text-gray-500 hover:text-gray-900'" class="px-2.5 py-1 rounded-md transition-all">
                                    Profil
                                </button>
                                <button @click="tab = 'history'" :class="tab === 'history' ? 'bg-brand-500 text-white font-bold shadow-sm' : 'text-gray-500 hover:text-gray-900'" class="px-2.5 py-1 rounded-md transition-all">
                                    {{ __('members.loan_history') }} ({{ count($loanHistory) }})
                                </button>
                            </div>
                        @endif
                    </div>
                    <button wire:click="closeModal" class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Profile Tab --}}
                <div x-show="tab === 'profile'">
                    <form wire:submit.prevent="save" class="space-y-4">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="form-label">{{ __('members.name') }} *</label>
                                <input wire:model="name" type="text" class="form-input">
                                @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="form-label">{{ __('members.email') }} *</label>
                                <input wire:model="email" type="email" class="form-input">
                                @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="form-label">{{ __('members.member_number') }}</label>
                                <input wire:model="member_number" type="text" placeholder="LIB-2026-XXXX" class="form-input font-mono">
                                @error('member_number') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="form-label">{{ __('members.phone') }}</label>
                                <input wire:model="phone" type="text" placeholder="08xxxxxxxxxx" class="form-input font-mono">
                                @error('phone') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="form-label">{{ __('members.member_type') }} *</label>
                                <select wire:model="member_type" class="form-select">
                                    <option value="SD">{{ __('members.type_SD') }}</option>
                                    <option value="SMP">{{ __('members.type_SMP') }}</option>
                                    <option value="SMA">{{ __('members.type_SMA') }}</option>
                                    <option value="Guru">{{ __('members.type_Guru') }}</option>
                                    <option value="Mahasiswa">{{ __('members.type_Mahasiswa') }}</option>
                                    <option value="Lainnya">{{ __('members.type_Lainnya') }}</option>
                                </select>
                                @error('member_type') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="form-label">{{ __('members.status') }} *</label>
                                <select wire:model="status" class="form-select">
                                    <option value="active">{{ __('common.active') }}</option>
                                    <option value="inactive">{{ __('common.inactive') }}</option>
                                </select>
                                @error('status') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
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

                {{-- History Tab --}}
                @if($memberId)
                <div x-show="tab === 'history'">
                    <div class="max-h-80 overflow-y-auto divide-y divide-gray-100 rounded-xl border border-gray-200">
                        @forelse($loanHistory as $loan)
                            <div class="flex items-center justify-between p-3.5 hover:bg-gray-50 transition-colors">
                                <div>
                                    <p class="text-sm font-bold text-gray-900">{{ $loan['book']['title'] ?? '-' }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Pinjam: {{ $loan['loan_date'] }} · Due: {{ $loan['due_date'] }}</p>
                                </div>
                                <div class="text-right flex-shrink-0 ml-4">
                                    <span class="{{ $loan['status'] === 'returned' ? 'badge-success' : ($loan['status'] === 'overdue' ? 'badge-danger' : 'badge-warning') }}">
                                        {{ $loan['status'] }}
                                    </span>
                                    @if(($loan['fine_amount'] ?? 0) > 0)
                                        <p class="text-xs text-red-500 mt-1 font-mono">Rp{{ number_format($loan['fine_amount']) }}</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="py-8 text-center text-sm text-gray-400">Belum ada riwayat peminjaman.</p>
                        @endforelse
                    </div>
                </div>
                @endif

            </div>
        </div>
    @endif
</div>
