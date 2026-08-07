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
        if (empty($data['isbn'])) {
            $nextId = (Book::max('id') ?? 0) + 1;
            $data['isbn'] = 'BK-' . date('Y') . '-' . str_pad((string) $nextId, 5, '0', STR_PAD_LEFT);
        }

        if (!isset($data['available_copies'])) {
            $data['available_copies'] = $data['total_copies'] ?? 1;
        }

        return $this->bookRepository->create($data, $genreIds);
    }
}
