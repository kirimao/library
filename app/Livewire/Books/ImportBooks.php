<?php

namespace App\Livewire\Books;

use App\Actions\Book\ImportBooksFromCsvAction;
use Exception;
use Livewire\Component;
use Livewire\WithFileUploads;

class ImportBooks extends Component
{
    use WithFileUploads;

    public $csv_file;
    public ?array $result = null;

    protected function rules()
    {
        return [
            'csv_file' => 'required|file|mimes:csv,txt|max:10240', // 10MB max
        ];
    }

    protected function messages()
    {
        return [
            'csv_file.required' => 'Silakan pilih file CSV terlebih dahulu.',
            'csv_file.mimes' => 'File harus berformat CSV atau TXT.',
            'csv_file.max' => 'Ukuran file CSV tidak boleh melebihi 10 MB.',
        ];
    }

    public function import(ImportBooksFromCsvAction $importAction)
    {
        $this->validate();

        try {
            $this->result = $importAction->execute($this->csv_file);
            session()->flash('success', 'Proses impor file CSV selesai!');
            $this->reset('csv_file');
        } catch (Exception $e) {
            session()->flash('error', 'Gagal memproses file CSV: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.books.import-books')
            ->layout('layouts.app');
    }
}
