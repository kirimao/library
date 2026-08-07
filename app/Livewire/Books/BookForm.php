<?php

namespace App\Livewire\Books;

use App\Actions\Book\CreateBookAction;
use App\Actions\Book\ProcessBookCoverAction;
use App\Actions\Book\UpdateBookAction;
use App\Repositories\Contracts\BookRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\GenreRepositoryInterface;
use Livewire\Component;
use Livewire\WithFileUploads;

class BookForm extends Component
{
    use WithFileUploads;

    public ?int $bookId = null;
    public string $title = '';
    public string $author = '';
    public string $isbn = '';
    public ?int $category_id = null;
    public array $genre_ids = [];
    public string $genreSearch = '';
    public ?string $publisher = '';
    public $price = null;
    public ?string $cover_type = '';
    public ?int $year = null;
    public ?int $arrival_month = null;
    public ?int $arrival_year = null;
    public int $total_copies = 1;
    public ?string $shelf_location = '';
    public $cover_image_file = null;
    public ?string $currentCoverImage = null;
    public ?string $currentCoverThumbnail = null;

    public bool $isOpen = false;

    protected $listeners = ['openBookModal' => 'loadBook'];

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:50|unique:books,isbn,' . ($this->bookId ?? 'NULL') . ',id',
            'category_id' => 'required|exists:categories,id',
            'genre_ids' => 'nullable|array',
            'genre_ids.*' => 'exists:genres,id',
            'publisher' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'cover_type' => 'nullable|string|max:50',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'arrival_month' => 'nullable|integer|min:1|max:12',
            'arrival_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'total_copies' => 'required|integer|min:1',
            'shelf_location' => 'nullable|string|max:100',
            'cover_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ];
    }

    protected function messages()
    {
        return [
            'cover_image_file.max' => 'Ukuran file gambar cover tidak boleh melebihi 5 MB.',
            'cover_image_file.image' => 'File cover harus berupa file gambar.',
            'cover_image_file.mimes' => 'Format gambar cover harus berupa JPEG, PNG, JPG, atau WebP.',
        ];
    }

    public function loadBook(?int $id = null)
    {
        $this->resetValidation();
        $this->reset(['bookId', 'title', 'author', 'isbn', 'category_id', 'genre_ids', 'genreSearch', 'publisher', 'price', 'cover_type', 'year', 'arrival_month', 'arrival_year', 'total_copies', 'shelf_location', 'cover_image_file', 'currentCoverImage', 'currentCoverThumbnail']);

        if ($id) {
            $book = app(BookRepositoryInterface::class)->findById($id);
            $this->bookId = $book->id;
            $this->title = $book->title;
            $this->author = $book->author;
            $this->isbn = $book->isbn;
            $this->category_id = $book->category_id;
            $this->genre_ids = $book->genres->pluck('id')->toArray();
            $this->publisher = $book->publisher ?? '';
            $this->price = $book->price;
            $this->cover_type = $book->cover_type ?? '';
            $this->year = $book->year;
            $this->arrival_month = $book->arrival_month;
            $this->arrival_year = $book->arrival_year;
            $this->total_copies = $book->total_copies;
            $this->shelf_location = $book->shelf_location ?? '';
            $this->currentCoverImage = $book->cover_image;
            $this->currentCoverThumbnail = $book->cover_thumbnail;
        }

        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset(['bookId', 'title', 'author', 'isbn', 'category_id', 'genre_ids', 'genreSearch', 'publisher', 'price', 'cover_type', 'year', 'arrival_month', 'arrival_year', 'total_copies', 'shelf_location', 'cover_image_file', 'currentCoverImage', 'currentCoverThumbnail']);
        $this->resetValidation();
    }

    public function save(
        CreateBookAction $createBookAction,
        UpdateBookAction $updateBookAction,
        ProcessBookCoverAction $processBookCoverAction
    ) {
        $validated = $this->validate();
        $genreIds = $validated['genre_ids'] ?? [];
        unset($validated['genre_ids'], $validated['cover_image_file']);

        if ($this->cover_image_file) {
            try {
                $coverPaths = $processBookCoverAction->execute(
                    $this->cover_image_file,
                    $this->currentCoverImage,
                    $this->currentCoverThumbnail
                );
                $validated['cover_image'] = $coverPaths['cover_image'];
                $validated['cover_thumbnail'] = $coverPaths['cover_thumbnail'];
            } catch (\Exception $e) {
                session()->flash('error', 'Gagal memproses gambar cover: ' . $e->getMessage());
                return;
            }
        }

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

        if (!empty(trim($this->genreSearch))) {
            $search = trim($this->genreSearch);
            $allGenres = $allGenres->filter(function ($genre) use ($search) {
                return stripos($genre->name, $search) !== false;
            });
        }

        return view('livewire.books.book-form', compact('categories', 'allGenres'));
    }
}
