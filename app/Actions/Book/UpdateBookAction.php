<?php

namespace App\Actions\Book;

use App\Models\Book;
use App\Repositories\Contracts\BookRepositoryInterface;

class UpdateBookAction
{
    public function __construct(
        protected BookRepositoryInterface $bookRepository
    ) {}

    public function execute(int $id, array $data, array $genreIds = []): Book
    {
        return $this->bookRepository->update($id, $data, $genreIds);
    }
}
