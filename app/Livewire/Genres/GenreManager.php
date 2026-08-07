<?php

namespace App\Livewire\Genres;

use App\Actions\Genre\CreateGenreAction;
use App\Actions\Genre\DeleteGenreAction;
use App\Actions\Genre\UpdateGenreAction;
use App\Models\Genre;
use App\Repositories\Contracts\GenreRepositoryInterface;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class GenreManager extends Component
{
    use WithPagination;

    public string $search = '';
    public int|string $perPage = 10;
    public $name = '';
    public $editingGenreId = null;
    public $isOpen = false;

    // Delete modal states
    public bool $isDeleteModalOpen = false;
    public ?Genre $deletingGenre = null;
    public int $deletingBooksCount = 0;

    protected $rules = [
        'name' => 'required|string|max:100|unique:genres,name',
    ];

    public function mount(): void
    {
        $allowed = [10, 25, 50, 'all'];
        $saved = session('perPage_genres', 10);
        $this->perPage = in_array($saved, $allowed, true) || in_array((int)$saved, [10, 25, 50], true) ? $saved : 10;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
        session(['perPage_genres' => $this->perPage]);
    }

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
        $this->resetValidation();
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

    public function confirmDelete(int $id)
    {
        $genreRepository = app(GenreRepositoryInterface::class);
        $this->deletingGenre = $genreRepository->findById($id);
        $this->deletingBooksCount = $this->deletingGenre->books()->count();
        $this->isDeleteModalOpen = true;
    }

    public function closeDeleteModal()
    {
        $this->isDeleteModalOpen = false;
        $this->deletingGenre = null;
        $this->deletingBooksCount = 0;
    }

    public function deleteGenre(DeleteGenreAction $deleteAction)
    {
        if (!$this->deletingGenre) return;

        try {
            $deleteAction->execute($this->deletingGenre->id);
            session()->flash('success', 'Genre berhasil dihapus!');
            $this->closeDeleteModal();
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
            $this->closeDeleteModal();
        }
    }

    public function render(GenreRepositoryInterface $genreRepository)
    {
        $perPageInt = $this->perPage === 'all'
            ? max(1, $genreRepository->getTotalCount())
            : (int) $this->perPage;

        return view('livewire.genres.genre-manager', [
            'genres' => $genreRepository->paginate($perPageInt, $this->search),
        ])->layout('layouts.app');
    }
}
