<?php

namespace App\Actions\Book;

use App\Models\Book;
use App\Repositories\Contracts\BookRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Gate;

/**
 * Class DeleteBookAction
 */
class DeleteBookAction
{
    public function __construct(
        protected BookRepositoryInterface $bookRepository
    ) {}

    public function execute(int $id): bool
    {
        $book = $this->bookRepository->findById($id);

        Gate::authorize('delete', $book);

        if ($book->available_copies < $book->total_copies) {
            throw new Exception(__('books.cannot_delete_borrowed'));
        }

        return $this->bookRepository->delete($id);
    }
}
