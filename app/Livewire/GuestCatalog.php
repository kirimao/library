<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\Category;
use App\Models\Genre;
use Livewire\Component;
use Livewire\WithPagination;

class GuestCatalog extends Component
{
    use WithPagination;

    public string $search = '';
    public ?int $categoryId = null;
    public ?int $genreId = null;
    public string $availability = '';
    public int|string $perPage = 12;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingCategoryId(): void
    {
        $this->resetPage();
    }

    public function updatingGenreId(): void
    {
        $this->resetPage();
    }

    public function updatingAvailability(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Book::with(['category', 'genres']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('author', 'like', '%' . $this->search . '%')
                  ->orWhere('publisher', 'like', '%' . $this->search . '%')
                  ->orWhere('isbn', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->categoryId) {
            $query->where('category_id', $this->categoryId);
        }

        if ($this->genreId) {
            $query->whereHas('genres', function ($q) {
                $q->where('genres.id', $this->genreId);
            });
        }

        if ($this->availability === 'available') {
            $query->where('available_copies', '>', 0);
        } elseif ($this->availability === 'unavailable') {
            $query->where('available_copies', '<=', 0);
        }

        $books = $query->latest()->paginate((int) $this->perPage);
        $categories = Category::orderBy('name')->get();
        $genres = Genre::orderBy('name')->get();

        return view('livewire.guest-catalog', compact('books', 'categories', 'genres'))
            ->layout('layouts.landing');
    }
}
