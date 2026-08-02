<?php

namespace App\Actions\Member;

use App\Models\Genre;
use App\Repositories\Contracts\LoanRepositoryInterface;

class GetMemberFavoriteGenreAction
{
    public function __construct(
        protected LoanRepositoryInterface $loanRepository
    ) {}

    public function execute(int $memberId): ?Genre
    {
        return $this->loanRepository->getFavoriteGenreForMember($memberId);
    }
}
