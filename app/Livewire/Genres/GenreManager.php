<?php

namespace App\Livewire\Genres;

use App\Actions\Genre\CreateGenreAction;
use App\Actions\Genre\DeleteGenreAction;
use App\Actions\Genre\UpdateGenreAction;
use App\Repositories\Contracts\GenreRepositoryInterface;
use Exception;
use Livewire\Component;

class GenreManager extends Component
{
    public $name = '';
    public $editingGenreId = null;
    public $isOpen = false;

    protected $rules = [
        'name' => 'required|string|max:100|unique:genres,name',
    ];

    public function openModal(?int $id = null)
    {
        $this->resetValidation();
        $this->editingGenreId = $id;

        if ($id) {
            $genreRepository = app(GenreRepositoryInterface::class);
            $genre = $genreRepository->findById($id);
            $this->name = $genre->name;
        } else {
            $this->name = '';
        }

        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset(['name', 'editingGenreId']);
    }

    public function save(CreateGenreAction $createAction, UpdateGenreAction $updateAction)
    {
        $rules = [
            'name' => 'required|string|max:100|unique:genres,name,' . ($this->editingGenreId ?? 'NULL'),
        ];
        $this->validate($rules);

        try {
            if ($this->editingGenreId) {
                $updateAction->execute($this->editingGenreId, ['name' => $this->name]);
                session()->flash('success', 'Genre berhasil diperbarui!');
            } else {
                $createAction->execute(['name' => $this->name]);
                session()->flash('success', 'Genre baru berhasil ditambahkan!');
            }

            $this->closeModal();
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function deleteGenre(int $id, DeleteGenreAction $deleteAction)
    {
        try {
            $deleteAction->execute($id);
            session()->flash('success', 'Genre berhasil dihapus!');
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render(GenreRepositoryInterface $genreRepository)
    {
        return view('livewire.genres.genre-manager', [
            'genres' => $genreRepository->all(),
        ])->layout('layouts.app');
    }
}
