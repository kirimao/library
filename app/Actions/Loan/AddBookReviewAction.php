<?php

namespace App\Actions\Loan;

use App\Models\BookReview;
use App\Models\Loan;
use App\Repositories\Contracts\BookReviewRepositoryInterface;
use Illuminate\Support\Carbon;

class AddBookReviewAction
{
    public function __construct(
        protected BookReviewRepositoryInterface $reviewRepository
    ) {}

    /**
     * Tambahkan ulasan/komentar anggota untuk sebuah buku.
     * Jika loanId tidak diberikan (on-site), buat atau update data pembaca (loan on_site)
     * agar anggota muncul di "Daftar Pembaca Buku Ini".
     */
    public function execute(
        int $bookId,
        int $memberId,
        string $comment,
        ?int $loanId = null,
        string $readingStatus = 'sedang_dibaca'
    ): BookReview {
        $resolvedLoanId = $loanId;

        // Jika bukan dari peminjaman (on-site reading), sync ke Daftar Pembaca
        if (!$loanId) {
            $today = Carbon::today()->toDateString();

            // Cari loan on_site yang sudah ada untuk member & buku ini
            $onSiteLoan = Loan::where('book_id', $bookId)
                ->where('member_id', $memberId)
                ->where('status', 'on_site')
                ->first();

            if ($onSiteLoan) {
                // Update reading_status yang ada
                $onSiteLoan->update(['reading_status' => $readingStatus]);
                $resolvedLoanId = $onSiteLoan->id;
            } else {
                // Buat entri "on-site" baru
                $newLoan = Loan::create([
                    'book_id'        => $bookId,
                    'member_id'      => $memberId,
                    'loan_date'      => $today,
                    'due_date'       => $today,
                    'return_date'    => $today,
                    'status'         => 'on_site',
                    'reading_status' => $readingStatus,
                    'fine_amount'    => 0,
                ]);
                $resolvedLoanId = $newLoan->id;
            }
        } else {
            // Berasal dari pengembalian buku — update reading_status jika diberikan
            Loan::where('id', $loanId)->update(['reading_status' => $readingStatus]);
        }

        return $this->reviewRepository->create([
            'book_id'   => $bookId,
            'member_id' => $memberId,
            'loan_id'   => $resolvedLoanId,
            'comment'   => $comment,
        ]);
    }
}
