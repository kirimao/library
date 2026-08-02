<?php

namespace App\Actions\Genre;

use App\Repositories\Contracts\LoanRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class GetPopularGenresAction
{
    public function __construct(
        protected LoanRepositoryInterface $loanRepository
    ) {}

    public function execute(?string $memberType = null, int $limit = 10): Collection
    {
        return $this->loanRepository->getPopularGenres($memberType, $limit);
    }
}
