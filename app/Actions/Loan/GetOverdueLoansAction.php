<?php

namespace App\Actions\Loan;

use App\Repositories\Contracts\LoanRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

/**
 * Class GetOverdueLoansAction
 *
 * Single Responsibility Action Class untuk mengambil semua data peminjaman yang terlambat (overdue).
 * Digunakan untuk menampilkan daftar peringatan keterlambatan di Livewire OverdueList
 * dan menghitung badge counter keterlambatan di sidebar navigation.
 */
class GetOverdueLoansAction
{
    public function __construct(
        protected LoanRepositoryInterface $loanRepository
    ) {}

    /**
     * Ambil daftar peminjaman terlambat dengan kalkulasi hari keterlambatan.
     *
     * @return Collection
     */
    public function execute(): Collection
    {
        $overdueLoans = $this->loanRepository->getOverdueLoans();

        // Tambahkan atribut kalkulasi jumlah hari keterlambatan untuk tampilan UI
        $today = Carbon::today();
        foreach ($overdueLoans as $loan) {
            $dueDate = Carbon::parse($loan->due_date);
            $loan->days_late = (int) $dueDate->diffInDays($today);
        }

        return $overdueLoans;
    }

    /**
     * Ambil jumlah total peminjaman terlambat untuk badge sidebar.
     *
     * @return int
     */
    public function count(): int
    {
        return $this->loanRepository->getOverdueLoansCount();
    }
}
