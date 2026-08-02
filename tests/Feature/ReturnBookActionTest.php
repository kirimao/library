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
