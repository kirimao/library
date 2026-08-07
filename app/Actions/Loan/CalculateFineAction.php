<?php

namespace App\Actions\Loan;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Support\Carbon;

class CalculateFineAction
{
    /**
     * Hitung besaran denda untuk transaksi peminjaman.
     *
     * @param Loan|string|Carbon $dueDate Tanggal Jatuh Tempo
     * @param string|Carbon|null $returnDate Tanggal Pengembalian (default: hari ini)
     * @param Book|null $book Model Buku (opsional untuk menghitung denda berbasis harga)
     * @return float
     */
    public function execute($dueDate, $returnDate = null, ?Book $book = null): float
    {
        if (!config('library.enable_fines', true)) {
            return 0.00;
        }

        if ($dueDate instanceof Loan) {
            $loan = $dueDate;
            $due = Carbon::parse($loan->due_date);
            $returned = $returnDate ? Carbon::parse($returnDate) : ($loan->return_date ? Carbon::parse($loan->return_date) : Carbon::now());
            if (!$book && $loan->relationLoaded('book')) {
                $book = $loan->book;
            }
        } else {
            $due = Carbon::parse($dueDate);
            $returned = $returnDate ? Carbon::parse($returnDate) : Carbon::now();
        }

        if ($returned->startOfDay()->greaterThan($due->startOfDay())) {
            $daysLate = $due->startOfDay()->diffInDays($returned->startOfDay());
            if ($daysLate < 1) {
                $daysLate = 1;
            }

            if ($book && $book->price && (float)$book->price > 0) {
                $percentage = config('library.late_fine_percentage', 1);
                $finePerDay = ((float)$book->price * $percentage) / 100;
            } else {
                $finePerDay = (float) config('library.default_daily_fine', config('library.fine_per_day', 5000));
            }

            return round($daysLate * $finePerDay, 2);
        }

        return 0.00;
    }
}
