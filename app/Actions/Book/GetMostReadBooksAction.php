<?php

namespace App\Actions\Book;

use App\Repositories\Contracts\LoanRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class GetMostReadBooksAction
{
    public function __construct(
        protected LoanRepositoryInterface $loanRepository
    ) {}

    public function execute(?int $genreId = null, ?string $memberType = null, int $limit = 10): Collection
    {
        return $this->loanRepository->getMostReadBooks($genreId, $memberType, $limit);
    }
}
