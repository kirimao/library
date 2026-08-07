<?php

namespace App\Actions\Loan;

use App\Models\Loan;
use App\Repositories\Contracts\BookRepositoryInterface;
use App\Repositories\Contracts\LoanRepositoryInterface;
use Exception;
use Illuminate\Support\Carbon;

class ReportLostBookAction
{
    public function __construct(
        protected LoanRepositoryInterface $loanRepository,
        protected BookRepositoryInterface $bookRepository
    ) {}

    /**
     * Process a lost book report.
     *
     * @param int $loanId
     * @param int|null $userId User reporting the loss
     * @param float|null $customFee Custom fine/replacement fee
     * @return Loan
     * @throws Exception
     */
    public function execute(int $loanId, ?int $userId = null, ?float $customFee = null): Loan
    {
        $loan = $this->loanRepository->findById($loanId);

        if (!$loan) {
            throw new Exception(__('loans.loan_not_found'));
        }

        if (in_array($loan->status, ['returned', 'hilang'])) {
            throw new Exception('Transaksi peminjaman ini sudah selesai atau telah dilaporkan hilang.');
        }

        $book = $loan->book?->fresh();

        // Calculate replacement fee
        if ($customFee !== null && $customFee >= 0) {
            $lostFee = $customFee;
        } elseif ($book && $book->price && (float)$book->price > 0) {
            $lostFee = (float) $book->price;
        } else {
            $lostFee = (float) config('library.default_lost_book_fee', 50000);
        }

        $now = Carbon::now();

        // Update loan status
        $updatedLoan = $this->loanRepository->update($loan->id, [
            'return_date' => $now,
            'status' => 'hilang',
            'fine_amount' => $lostFee,
            'reported_lost_by' => $userId ?? auth()->id(),
            'reported_lost_at' => $now,
        ]);

        // Decrement total_copies for lost book (and make sure available_copies is not negative)
        if ($book) {
            $newTotal = max(0, $book->total_copies - 1);
            $newAvailable = min($book->available_copies, $newTotal);

            $this->bookRepository->update($book->id, [
                'total_copies' => $newTotal,
                'available_copies' => $newAvailable,
            ]);
        }

        return $updatedLoan;
    }
}
