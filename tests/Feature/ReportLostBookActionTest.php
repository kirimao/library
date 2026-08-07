<?php

use App\Actions\Loan\BorrowBookAction;
use App\Actions\Loan\ReportLostBookAction;
use App\Models\Book;
use App\Models\Category;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('reporting lost book sets status to hilang, records fee, and decrements total copies', function () {
    $category = Category::create(['name' => 'Fiction', 'code' => 'FIC']);
    $book = Book::create([
        'title' => 'Buku Mahal',
        'author' => 'Penulis',
        'category_id' => $category->id,
        'total_copies' => 3,
        'available_copies' => 3,
        'price' => 150000.00,
    ]);

    $member = Member::create([
        'member_number' => 'LIB-LOST-01',
        'name' => 'Pemilik Peminjaman',
        'status' => 'active',
    ]);

    $borrowAction = app(BorrowBookAction::class);
    $loan = $borrowAction->execute($member->id, $book->id);

    $lostAction = app(ReportLostBookAction::class);
    $lostLoan = $lostAction->execute($loan->id);

    expect($lostLoan->status)->toBe('hilang');
    expect((float) $lostLoan->fine_amount)->toBe(150000.00);
    expect($book->fresh()->total_copies)->toBe(2);
    expect($book->fresh()->available_copies)->toBe(2);
});
