<?php

namespace App\Livewire\Books;

use App\Actions\Book\CreateBookAction;
use App\Actions\Book\UpdateBookAction;
use App\Repositories\Contracts\BookRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\GenreRepositoryInterface;
use Livewire\Component;

class BookForm extends Component
{
    public ?int $bookId = null;
    public string $title = '';
    public string $author = '';
    public string $isbn = '';
    public ?int $category_id = null;
    public array $genre_ids = [];
    public string $publisher = '';
    public ?int $year = null;
    public int $total_copies = 1;
    public ?string $shelf_location = '';

    public bool $isOpen = false;

    protected $listeners = ['openBookModal' => 'loadBook'];

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|max:50|unique:books,isbn,' . ($this->bookId ?? 'NULL') . ',id',
            'category_id' => 'required|exists:categories,id',
            'genre_ids' => 'nullable|array',
            'genre_ids.*' => 'exists:genres,id',
            'publisher' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'total_copies' => 'required|integer|min:1',
            'shelf_location' => 'nullable|string|max:100',
        ];
    }

    public function loadBook(?int $id = null)
    {
        $this->resetValidation();
        $this->reset();

        if ($id) {
            $book = app(BookRepositoryInterface::class)->findById($id);
            $this->bookId = $book->id;
            $this->title = $book->title;
            $this->author = $book->author;
            $this->isbn = $book->isbn;
            $this->category_id = $book->category_id;
            $this->genre_ids = $book->genres->pluck('id')->toArray();
            $this->publisher = $book->publisher ?? '';
            $this->year = $book->year;
            $this->total_copies = $book->total_copies;
            $this->shelf_location = $book->shelf_location ?? '';
        }

        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset();
        $this->resetValidation();
    }

    public function save(CreateBookAction $createBookAction, UpdateBookAction $updateBookAction)
    {
        $validated = $this->validate();
        $genreIds = $validated['genre_ids'] ?? [];
        unset($validated['genre_ids']);

        if ($this->bookId) {
            $updateBookAction->execute($this->bookId, $validated, $genreIds);
            session()->flash('success', __('books.updated_success'));
        } else {
            $createBookAction->execute($validated, $genreIds);
            session()->flash('success', __('books.created_success'));
        }

        $this->dispatch('bookSaved');
        $this->closeModal();
    }

    public function render(
        CategoryRepositoryInterface $categoryRepository,
        GenreRepositoryInterface $genreRepository
    ) {
        $categories = $categoryRepository->all();
        $allGenres = $genreRepository->all();

        return view('livewire.books.book-form', compact('categories', 'allGenres'));
    }
}
