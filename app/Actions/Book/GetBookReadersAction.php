<?php

namespace App\Actions\Book;

use App\Repositories\Contracts\LoanRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class GetBookReadersAction
{
    public function __construct(
        protected LoanRepositoryInterface $loanRepository
    ) {}

    public function execute(int $bookId): Collection
    {
        return $this->loanRepository->getReadersForBook($bookId);
    }
}
