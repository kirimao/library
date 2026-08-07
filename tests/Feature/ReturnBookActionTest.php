<?php

use App\Actions\Loan\BorrowBookAction;
use App\Actions\Loan\ReturnBookAction;
use App\Models\Book;
use App\Models\Category;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a borrowed book can be returned and restores available stock', function () {
    $category = Category::create(['name' => 'Fiction', 'code' => 'FIC']);
    $book = Book::create([
        'title' => 'Laskar Pelangi',
        'author' => 'Andrea Hirata',
        'isbn' => '978-9793062792',
        'category_id' => $category->id,
        'total_copies' => 5,
        'available_copies' => 5,
    ]);

    $member = Member::create([
        'member_number' => 'LIB-TEST-003',
        'name' => 'Member Return Test',
        'email' => 'return@example.com',
        'status' => 'active',
    ]);

    $borrowAction = app(BorrowBookAction::class);
    $loan = $borrowAction->execute($member->id, $book->id);

    expect($book->fresh()->available_copies)->toBe(4);

    $returnAction = app(ReturnBookAction::class);
    $returnedLoan = $returnAction->execute($loan->id);

    expect($returnedLoan->status)->toBe('returned');
    expect($returnedLoan->return_date)->not->toBeNull();
    expect($book->fresh()->available_copies)->toBe(5);
});

test('returning a late book calculates fine and stores fine_amount in database', function () {
    $category = Category::create(['name' => 'Science', 'code' => 'SCI']);
    $book = Book::create([
        'title' => 'Fisika Dasar',
        'author' => 'Halliday',
        'isbn' => '978-0471320005',
        'category_id' => $category->id,
        'total_copies' => 3,
        'available_copies' => 3,
    ]);

    $member = Member::create([
        'member_number' => 'LIB-TEST-004',
        'name' => 'Late Borrower',
        'email' => 'late@example.com',
        'status' => 'active',
    ]);

    $borrowAction = app(BorrowBookAction::class);
    $loan = $borrowAction->execute($member->id, $book->id);

    // Simulated return date: 5 days after due date
    $lateReturnDate = \Illuminate\Support\Carbon::parse($loan->due_date)->addDays(5)->toDateString();

    $returnAction = app(ReturnBookAction::class);
    $returnedLoan = $returnAction->execute($loan->id, $lateReturnDate);

    expect($returnedLoan->status)->toBe('returned');
    expect((float) $returnedLoan->fine_amount)->toBeGreaterThan(0.0);
    expect((float) $returnedLoan->fine_amount)->toBe((float) (5 * config('library.default_daily_fine', 5000)));
    expect($book->fresh()->available_copies)->toBe(3);
});

test('returning a book on time results in zero fine', function () {
    $category = Category::create(['name' => 'Health', 'code' => 'HLT']);
    $book = Book::create([
        'title' => 'Buku Kesehatan',
        'author' => 'Dr. Sehat',
        'isbn' => '978-0000000001',
        'category_id' => $category->id,
        'total_copies' => 2,
        'available_copies' => 2,
    ]);

    $member = Member::create([
        'member_number' => 'LIB-TEST-005',
        'name' => 'Tepat Waktu',
        'email' => 'ontime@example.com',
        'status' => 'active',
    ]);

    $borrowAction = app(BorrowBookAction::class);
    $loan = $borrowAction->execute($member->id, $book->id);

    // Return exactly on due date (no fine)
    $onTimeReturn = \Illuminate\Support\Carbon::parse($loan->due_date)->toDateString();

    $returnAction = app(ReturnBookAction::class);
    $returnedLoan = $returnAction->execute($loan->id, $onTimeReturn);

    expect($returnedLoan->status)->toBe('returned');
    expect((float) $returnedLoan->fine_amount)->toBe(0.0);
    expect($returnedLoan->return_date)->not->toBeNull();
});

test('late fine is calculated as percentage of book price when price is set', function () {
    $category = Category::create(['name' => 'Premium', 'code' => 'PRM']);
    $book = Book::create([
        'title' => 'Buku Mahal Premium',
        'author' => 'Penulis',
        'isbn' => '978-0000000002',
        'category_id' => $category->id,
        'total_copies' => 1,
        'available_copies' => 1,
        'price' => 100000.00,
    ]);

    $member = Member::create([
        'member_number' => 'LIB-TEST-006',
        'name' => 'Peminjam Mahal',
        'status' => 'active',
    ]);

    $borrowAction = app(BorrowBookAction::class);
    $loan = $borrowAction->execute($member->id, $book->id);

    // Return 3 days late
    $lateReturn = \Illuminate\Support\Carbon::parse($loan->due_date)->addDays(3)->toDateString();

    $returnAction = app(ReturnBookAction::class);
    $returnedLoan = $returnAction->execute($loan->id, $lateReturn);

    // Expected: 3 days * (100000 * 1%) = 3 * 1000 = 3000
    $percentage = config('library.late_fine_percentage', 1);
    $expectedFine = 3 * (100000 * $percentage / 100);

    expect($returnedLoan->status)->toBe('returned');
    expect((float) $returnedLoan->fine_amount)->toBe((float) $expectedFine);
});
