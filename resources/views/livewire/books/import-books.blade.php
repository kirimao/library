<div class="space-y-6 max-w-4xl mx-auto">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-black text-gray-900">Impor Data Buku dari CSV</h1>
            <p class="text-xs text-gray-500 mt-1">Unggah file CSV berisi data buku untuk diimpor secara massal ke dalam sistem perpustakaan.</p>
        </div>
        <a href="{{ route('books.index') }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs transition-all self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Kembali ke Katalog</span>
        </a>
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

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Form Upload (2 Cols) --}}
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white border border-gray-200 rounded-3xl p-6 shadow-sm space-y-5">
                <h3 class="text-base font-extrabold text-gray-900 pb-3 border-b border-gray-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    <span>Upload File CSV</span>
                </h3>

                <form wire:submit.prevent="import" class="space-y-4">
                    <div class="p-6 border-2 border-dashed border-gray-200 rounded-2xl bg-gray-50/50 hover:bg-gray-50 transition-all text-center">
                        <svg class="w-10 h-10 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-xs font-semibold text-gray-700 mb-1">Pilih atau drag & drop file CSV</p>
                        <p class="text-[11px] text-gray-400">Format file: CSV / TXT (Maks. 10MB)</p>

                        <input type="file" wire:model="csv_file" accept=".csv,.txt" class="mt-4 block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 cursor-pointer">
                        @error('csv_file')
                            <p class="text-xs font-bold text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="btn-primary" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="csv_file, import">Mulai Impor CSV</span>
                            <span wire:loading wire:target="import" class="flex items-center gap-2">
                                <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Memproses Data...
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Result Summary --}}
            @if($result)
                <div class="bg-white border border-gray-200 rounded-3xl p-6 shadow-sm space-y-4">
                    <h3 class="text-base font-extrabold text-gray-900 pb-3 border-b border-gray-100 flex items-center justify-between">
                        <span>Ringkasan Hasil Impor</span>
                        <span class="text-xs font-mono px-2.5 py-1 rounded-full bg-gray-100 text-gray-700 font-bold">Total: {{ $result['total'] }} Baris</span>
                    </h3>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-center">
                            <span class="block text-2xl font-black text-emerald-700">{{ $result['imported'] }}</span>
                            <span class="text-xs font-bold text-emerald-800">Berhasil Diimpor</span>
                        </div>
                        <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-center">
                            <span class="block text-2xl font-black text-amber-700">{{ $result['skipped'] }}</span>
                            <span class="text-xs font-bold text-amber-800">Di-skip (Duplikat)</span>
                        </div>
                        <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-center">
                            <span class="block text-2xl font-black text-red-700">{{ $result['failed'] }}</span>
                            <span class="text-xs font-bold text-red-800">Gagal (Invalid)</span>
                        </div>
                    </div>

                    @if(count($result['errors']) > 0)
                        <div class="pt-3 border-t border-gray-100 space-y-2">
                            <h4 class="text-xs font-bold text-red-800 uppercase tracking-wider">Rincian Data Gagal / Tidak Valid:</h4>
                            <div class="max-h-40 overflow-y-auto p-3 rounded-xl bg-red-50/70 border border-red-200 text-xs text-red-700 space-y-1 font-mono">
                                @foreach($result['errors'] as $err)
                                    <p>• {{ $err }}</p>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        {{-- Guide & Template Info (1 Col) --}}
        <div class="space-y-6">
            <div class="bg-white border border-gray-200 rounded-3xl p-6 shadow-sm space-y-4">
                <h3 class="text-sm font-extrabold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Format Kolom CSV</span>
                </h3>

                <div class="space-y-2.5 text-xs text-gray-600">
                    <p class="font-semibold text-gray-800">Struktur urutan kolom (8 kolom):</p>
                    <ol class="list-decimal list-inside space-y-1 font-mono text-[11px] text-gray-700 bg-gray-50 p-3 rounded-xl border border-gray-200">
                        <li>Title <span class="text-red-500 font-bold">*Wajib</span></li>
                        <li>Author</li>
                        <li>Publisher</li>
                        <li>Category</li>
                        <li>Cover Type</li>
                        <li>Shelf</li>
                        <li>Quantity</li>
                        <li>Unit Price</li>
                    </ol>
                    <div class="text-[11px] text-gray-500 space-y-1 pt-1">
                        <p>• <strong>Cover Type</strong>: Tipe sampul fisik (misal: Paperback / Hardcover).</p>
                        <li>• Kombinasi <strong>Judul + Penulis</strong> yang sudah ada akan otomatis <em>di-skip</em>.</li>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
