<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class LoanSeeder extends Seeder
{
    public function run(): void
    {
        $budi = Member::where('member_number', 'LIB-2026-0001')->first();
        $siti = Member::where('member_number', 'LIB-2026-0002')->first();
        $hendra = Member::where('member_number', 'LIB-2026-0003')->first();
        $dewi = Member::where('member_number', 'LIB-2026-0004')->first();
        $rizky = Member::where('member_number', 'LIB-2026-0005')->first();

        $bookCleanCode = Book::where('isbn', '978-0132350884')->first();
        $bookLaravel = Book::where('isbn', '978-1492041214')->first();
        $bookLaskar = Book::where('isbn', '978-9793062792')->first();
        $bookSapiens = Book::where('isbn', '978-0062316097')->first();
        $bookAtomic = Book::where('isbn', '978-0735211292')->first();
        $bookRichDad = Book::where('isbn', '978-1612680194')->first();

        // 1. Overdue loans (Deliberately 10 days ago loan_date, due 3 days ago)
        if ($budi && $bookCleanCode) {
            Loan::create([
                'book_id' => $bookCleanCode->id,
                'member_id' => $budi->id,
                'loan_date' => Carbon::now()->subDays(12)->toDateString(),
                'due_date' => Carbon::now()->subDays(5)->toDateString(),
                'return_date' => null,
                'status' => 'overdue',
                'fine_amount' => 10000.00,
            ]);
            $bookCleanCode->decrement('available_copies');
        }

        if ($siti && $bookLaravel) {
            Loan::create([
                'book_id' => $bookLaravel->id,
                'member_id' => $siti->id,
                'loan_date' => Carbon::now()->subDays(15)->toDateString(),
                'due_date' => Carbon::now()->subDays(8)->toDateString(),
                'return_date' => null,
                'status' => 'overdue',
                'fine_amount' => 16000.00,
            ]);
            $bookLaravel->decrement('available_copies');
        }

        // 2. Active Borrowed loans (On time)
        if ($hendra && $bookSapiens) {
            Loan::create([
                'book_id' => $bookSapiens->id,
                'member_id' => $hendra->id,
                'loan_date' => Carbon::now()->subDays(2)->toDateString(),
                'due_date' => Carbon::now()->addDays(5)->toDateString(),
                'return_date' => null,
                'status' => 'borrowed',
                'fine_amount' => 0.00,
            ]);
            $bookSapiens->decrement('available_copies');
        }

        if ($dewi && $bookAtomic) {
            Loan::create([
                'book_id' => $bookAtomic->id,
                'member_id' => $dewi->id,
                'loan_date' => Carbon::now()->subDays(1)->toDateString(),
                'due_date' => Carbon::now()->addDays(6)->toDateString(),
                'return_date' => null,
                'status' => 'borrowed',
                'fine_amount' => 0.00,
            ]);
            $bookAtomic->decrement('available_copies');
        }

        // 3. Returned loans
        if ($rizky && $bookLaskar) {
            Loan::create([
                'book_id' => $bookLaskar->id,
                'member_id' => $rizky->id,
                'loan_date' => Carbon::now()->subDays(20)->toDateString(),
                'due_date' => Carbon::now()->subDays(13)->toDateString(),
                'return_date' => Carbon::now()->subDays(14)->toDateString(),
                'status' => 'returned',
                'fine_amount' => 0.00,
            ]);
        }

        if ($budi && $bookRichDad) {
            Loan::create([
                'book_id' => $bookRichDad->id,
                'member_id' => $budi->id,
                'loan_date' => Carbon::now()->subDays(30)->toDateString(),
                'due_date' => Carbon::now()->subDays(23)->toDateString(),
                'return_date' => Carbon::now()->subDays(20)->toDateString(),
                'status' => 'returned',
                'fine_amount' => 6000.00,
            ]);
        }
    }
}
