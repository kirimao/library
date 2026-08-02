<?php

namespace App\Actions\Loan;

use App\Models\Loan;
use App\Repositories\Contracts\BookRepositoryInterface;
use App\Repositories\Contracts\LoanRepositoryInterface;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReturnBookAction
{
    public function __construct(
        protected LoanRepositoryInterface $loanRepository,
        protected BookRepositoryInterface $bookRepository,
        protected CalculateFineAction $calculateFineAction,
        protected MarkReadingStatusAction $markReadingStatusAction,
        protected AddBookReviewAction $addBookReviewAction
    ) {}

    /**
     * Eksekusi pengembalian buku dengan status bacaan dan opsional komentar review.
     */
    public function execute(
        int $loanId,
        ?string $returnDate = null,
        string $readingStatus = 'selesai_dibaca',
        ?string $comment = null
    ): Loan {
        $loan = $this->loanRepository->findById($loanId);

        if ($loan->status === 'returned') {
            throw new Exception(__('loans.already_returned_error') ?? 'Peminjaman ini sudah dikembalikan sebelumnya.');
        }

        $actualReturnDate = $returnDate ? Carbon::parse($returnDate) : Carbon::today();
        $fineAmount = $this->calculateFineAction->execute($loan->due_date, $actualReturnDate);

        return DB::transaction(function () use ($loan, $actualReturnDate, $fineAmount, $readingStatus, $comment) {
            // Update loan status & denda
            $updatedLoan = $this->loanRepository->update($loan->id, [
                'return_date' => $actualReturnDate->toDateString(),
                'status' => 'returned',
                'reading_status' => $readingStatus,
                'fine_amount' => $fineAmount,
            ]);

            // Panggil MarkReadingStatusAction jika perlu
            $this->markReadingStatusAction->execute($loan->id, $readingStatus);

            // Tambahkan review jika komentar tidak kosong
            if (!empty(trim((string) $comment))) {
                $this->addBookReviewAction->execute(
                    $loan->book_id,
                    $loan->member_id,
                    trim($comment),
                    $loan->id,
                    $readingStatus
                );
            }

            // Kembalikan stok ketersediaan buku
            $this->bookRepository->incrementAvailableCopies($loan->book_id);

            return $updatedLoan;
        });
    }
}
