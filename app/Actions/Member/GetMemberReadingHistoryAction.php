<?php

namespace App\Actions\Member;

use App\Repositories\Contracts\LoanRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class GetMemberReadingHistoryAction
{
    public function __construct(
        protected LoanRepositoryInterface $loanRepository
    ) {}

    public function execute(int $memberId): Collection
    {
        return $this->loanRepository->getHistoryForMember($memberId);
    }
}
