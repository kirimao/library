<?php

namespace App\Actions\Loan;

use App\Models\Loan;
use Illuminate\Support\Carbon;

/**
 * Class CalculateFineAction
 *
 * Single Responsibility Action Class untuk menghitung denda keterlambatan pengembalian buku.
 * Menghitung selisih hari antara tanggal jatuh tempo (due_date) dan tanggal pengembalian (return_date).
 */
class CalculateFineAction
{
    /**
     * Hitung besaran denda untuk transaksi peminjaman.
     *
     * @param Loan|string|Carbon $dueDate Tanggal Jatuh Tempo
     * @param string|Carbon|null $returnDate Tanggal Pengembalian (default: hari ini)
     * @return float
     */
    public function execute($dueDate, $returnDate = null): float
    {
        if (!config('library.enable_fines', true)) {
            return 0.00;
        }

        if ($dueDate instanceof Loan) {
            $due = Carbon::parse($dueDate->due_date);
            $returned = $dueDate->return_date ? Carbon::parse($dueDate->return_date) : Carbon::today();
        } else {
            $due = Carbon::parse($dueDate);
            $returned = $returnDate ? Carbon::parse($returnDate) : Carbon::today();
        }

        // Hanya hitung jika tanggal pengembalian melebihi tanggal jatuh tempo
        if ($returned->greaterThan($due)) {
            $daysLate = $due->diffInDays($returned);
            $finePerDay = config('library.fine_per_day', 2000);
            return (float) ($daysLate * $finePerDay);
        }

        return 0.00;
    }
}
