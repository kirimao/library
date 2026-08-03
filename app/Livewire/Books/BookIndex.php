<?php

namespace App\Livewire\Books;

use App\Actions\Book\DeleteBookAction;
use App\Actions\Book\SearchBooksAction;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\GenreRepositoryInterface;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class BookIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public ?int $categoryId = null;
    public ?int $genreId = null;
    public ?string $arrivalStatus = null;
    public ?int $arrivalYear = null;
    public int $perPage = 10;

    protected $listeners = ['bookSaved' => '$refresh'];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingCategoryId() { $this->resetPage(); }
    public function updatingGenreId() { $this->resetPage(); }
    public function updatingArrivalStatus() { $this->resetPage(); }
    public function updatingArrivalYear() { $this->resetPage(); }

    public function deleteBook(int $id, DeleteBookAction $deleteBookAction)
    {
        try {
            $deleteBookAction->execute($id);
            session()->flash('success', __('books.deleted_success'));
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render(
        SearchBooksAction $searchBooksAction,
        CategoryRepositoryInterface $categoryRepository,
        GenreRepositoryInterface $genreRepository
    ) {
        $books = $searchBooksAction->execute(
            $this->search,
            $this->categoryId,
            $this->genreId,
            $this->arrivalStatus,
            $this->arrivalYear,
            $this->perPage
        );
        $categories = $categoryRepository->all();
        $genres = $genreRepository->all();
        $availableArrivalYears = \App\Models\Book::whereNotNull('arrival_year')
            ->distinct()
            ->orderBy('arrival_year', 'desc')
            ->pluck('arrival_year');

        return view('livewire.books.book-index', compact('books', 'categories', 'genres', 'availableArrivalYears'))
            ->layout('layouts.app');
    }
}
