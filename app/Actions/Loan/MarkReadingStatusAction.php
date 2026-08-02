<?php

namespace App\Actions\Loan;

use App\Models\Loan;
use App\Repositories\Contracts\LoanRepositoryInterface;

class MarkReadingStatusAction
{
    public function __construct(
        protected LoanRepositoryInterface $loanRepository
    ) {}

    public function execute(int $loanId, string $readingStatus): Loan
    {
        return $this->loanRepository->updateReadingStatus($loanId, $readingStatus);
    }
}
