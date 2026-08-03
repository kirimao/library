<div class="space-y-5">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-black text-gray-900">{{ __('categories.title') }}</h1>
            <p class="text-sm text-gray-400 mt-0.5">{{ __('categories.subtitle') }}</p>
        </div>
        <button wire:click="openModal" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            {{ __('categories.add_category') }}
        </button>
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

    {{-- Table --}}
    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr>
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-left">{{ __('categories.category_name') }}</th>
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-left">{{ __('categories.category_code') }} / {{ __('categories.slug') }}</th>
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-center">{{ __('categories.books_count') }}</th>
                        <th class="py-3.5 px-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 bg-gray-50 border-b border-gray-200 text-right">{{ __('common.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3.5 px-4">
                                <span class="badge-neutral font-bold">{{ $category->name }}</span>
                            </td>
                            <td class="py-3.5 px-4 font-mono text-xs text-gray-500">
                                <div class="flex items-center gap-2">
                                    @if($category->code)
                                        <span class="px-2 py-0.5 rounded bg-gray-100 font-bold text-[10px] text-gray-700">{{ $category->code }}</span>
                                    @endif
                                    <span class="text-gray-400">{{ $category->slug }}</span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-full text-xs font-bold bg-brand-50 text-brand-700 border border-brand-200">
                                    {{ $category->books()->count() }} {{ __('books.title') }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @can('update', $category)
                                        <button wire:click="openModal({{ $category->id }})"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-brand-50 hover:bg-brand-100 text-brand-700 font-semibold text-xs border border-brand-200 transition-all">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            {{ __('common.edit') }}
                                        </button>
                                    @endcan

                                    @can('delete', $category)
                                        <button wire:click="confirmDelete({{ $category->id }})"
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
                            <td colspan="4" class="py-12 text-center text-gray-400 text-sm">{{ __('categories.no_categories') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Form (Tambah / Edit) --}}
    @if($isOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" wire:click="closeModal"></div>
            <div class="relative bg-white rounded-3xl border border-gray-100 shadow-2xl p-6 w-full my-auto z-10" style="max-width: 480px; width: 100%; margin-left: auto; margin-right: auto;">
                <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-100">
                    <h3 class="text-base font-bold text-gray-900">
                        {{ $editingCategoryId ? __('categories.edit_category') : __('categories.add_category') }}
                    </h3>
                    <button wire:click="closeModal" class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="save" class="space-y-4">
                    <div>
                        <label class="form-label">{{ __('categories.category_name') }} *</label>
                        <input wire:model="name" type="text" placeholder="Contoh: Teknologi, Fiksi" class="form-input">
                        @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="form-label">{{ __('categories.category_code') }}</label>
                            <input wire:model="code" type="text" placeholder="TECH, FIC" class="form-input font-mono uppercase">
                            @error('code') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">{{ __('categories.slug') }}</label>
                            <input wire:model="slug" type="text" placeholder="teknologi" class="form-input font-mono">
                            @error('slug') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
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

    {{-- Modal Konfirmasi Hapus --}}
    @if($isDeleteModalOpen && $deletingCategory)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" wire:click="closeDeleteModal"></div>
            <div class="relative bg-white rounded-3xl border border-gray-100 shadow-2xl p-6 w-full my-auto z-10" style="max-width: 480px; width: 100%; margin-left: auto; margin-right: auto;">
                
                {{-- Header --}}
                <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center {{ $deletingBooksCount > 0 ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-gray-900">
                            {{ __('categories.confirm_delete_title') }}
                        </h3>
                    </div>
                    <button wire:click="closeDeleteModal" class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <p class="text-sm text-gray-700">
                        {{ __('categories.confirm_delete_title') }}: <span class="font-extrabold text-gray-900">"{{ $deletingCategory->name }}"</span>
                    </p>

                    @if($deletingBooksCount > 0)
                        {{-- Strict Warning Box when books exist --}}
                        <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 space-y-2">
                            <div class="flex items-center gap-2 text-xs font-black uppercase tracking-wider text-amber-800">
                                <span>⚠️ {{ __('categories.delete_warning_used') }}</span>
                            </div>
                            <p class="text-xs leading-relaxed">
                                {{ __('categories.delete_used_message', ['count' => $deletingBooksCount]) }}
                            </p>
                        </div>

                        <div class="flex items-center justify-end pt-3 border-t border-gray-100">
                            <button wire:click="closeDeleteModal" class="px-5 py-2.5 rounded-xl bg-gray-900 text-white font-bold text-xs hover:bg-gray-800 transition-all">
                                {{ __('categories.understand_close') }}
                            </button>
                        </div>
                    @else
                        {{-- Normal Delete Confirmation --}}
                        <div class="p-3.5 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-xs leading-relaxed">
                            {{ __('categories.delete_unused_message') }}
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-100">
                            <button wire:click="closeDeleteModal" class="px-4 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs transition-all">
                                {{ __('common.cancel') }}
                            </button>
                            <button wire:click="deleteCategory" class="px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-sm transition-all active:scale-95">
                                {{ __('categories.confirm_delete_btn') }}
                            </button>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    @endif
</div>
