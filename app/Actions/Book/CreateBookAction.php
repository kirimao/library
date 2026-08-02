<?php

namespace App\Actions\Book;

use App\Models\Book;
use App\Repositories\Contracts\BookRepositoryInterface;

class CreateBookAction
{
    public function __construct(
        protected BookRepositoryInterface $bookRepository
    ) {}

    public function execute(array $data, array $genreIds = []): Book
    {
        if (!isset($data['available_copies'])) {
            $data['available_copies'] = $data['total_copies'] ?? 1;
        }

        return $this->bookRepository->create($data, $genreIds);
    }
}
