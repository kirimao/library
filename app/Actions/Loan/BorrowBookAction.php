<?php

namespace App\Actions\Loan;

use App\Models\Loan;
use App\Repositories\Contracts\BookRepositoryInterface;
use App\Repositories\Contracts\LoanRepositoryInterface;
use App\Repositories\Contracts\MemberRepositoryInterface;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class BorrowBookAction
 *
 * Single Responsibility Action Class untuk mencatat transaksi peminjaman buku baru.
 */
class BorrowBookAction
{
    public function __construct(
        protected BookRepositoryInterface $bookRepository,
        protected MemberRepositoryInterface $memberRepository,
        protected LoanRepositoryInterface $loanRepository
    ) {}

    /**
     * Eksekusi transaksi peminjaman buku.
     *
     * @param int $memberId ID Anggota
     * @param int $bookId ID Buku
     * @param int|null $customLoanDays (opsional) jumlah hari pinjam khusus
     * @param string|null $dueDateInput (opsional) tanggal jatuh tempo spesifik (Y-m-d)
     * @return Loan
     * @throws Exception
     */
    public function execute(int $memberId, int $bookId, ?int $customLoanDays = null, ?string $dueDateInput = null): Loan
    {
        $book = $this->bookRepository->findById($bookId);
        $member = $this->memberRepository->findById($memberId);

        // 1. Validasi status anggota
        if ($member->status !== 'active') {
            throw new Exception(__('members.inactive_error') ?? 'Status anggota tidak aktif.');
        }

        // 2. Validasi stok ketersediaan buku
        if ($book->available_copies <= 0) {
            throw new Exception(__('loans.out_of_stock_error'));
        }

        // 3. Validasi duplikasi peminjaman buku yang sama oleh anggota yang sama
        if ($this->loanRepository->hasActiveLoanForBook($memberId, $bookId)) {
            throw new Exception(__('loans.already_borrowed_error'));
        }

        // 4. Validasi batas maksimal peminjaman aktif per anggota
        $activeLoans = $this->loanRepository->getActiveLoansForMember($memberId);
        $maxLimit = config('library.max_books_per_member', 3);
        if ($activeLoans->count() >= $maxLimit) {
            throw new Exception(__('loans.max_loans_reached'));
        }

        // 5. Hitung tanggal peminjaman dan jatuh tempo
        $loanDate = Carbon::today();
        if ($dueDateInput) {
            $dueDate = Carbon::parse($dueDateInput);
        } elseif ($customLoanDays) {
            $dueDate = $loanDate->copy()->addDays($customLoanDays);
        } else {
            $dueDate = $loanDate->copy()->addDays(config('library.default_loan_days', 7));
        }

        // 6. Jalankan peminjaman dalam transaksi DB
        return DB::transaction(function () use ($bookId, $memberId, $loanDate, $dueDate) {
            $this->bookRepository->decrementAvailableCopies($bookId);
            return $this->loanRepository->create([
                'book_id' => $bookId,
                'member_id' => $memberId,
                'loan_date' => $loanDate->toDateString(),
                'due_date' => $dueDate->toDateString(),
                'status' => 'borrowed',
                'fine_amount' => 0,
            ]);
        });
    }
}
