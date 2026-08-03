<?php

namespace App\Actions\Book;

use App\Repositories\Contracts\BookRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SearchBooksAction
{
    public function __construct(
        protected BookRepositoryInterface $bookRepository
    ) {}

    public function execute(?string $search = null, ?int $categoryId = null, ?int $genreId = null, ?string $arrivalStatus = null, ?int $arrivalYear = null, int $perPage = 10): LengthAwarePaginator
    {
        return $this->bookRepository->paginate($perPage, $search, $categoryId, $genreId, $arrivalStatus, $arrivalYear);
    }
}
