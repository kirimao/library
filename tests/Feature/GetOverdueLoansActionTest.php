<?php

use App\Actions\Loan\GetOverdueLoansAction;
use App\Models\Book;
use App\Models\Category;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

uses(RefreshDatabase::class);

test('it correctly identifies overdue loans and calculates days late', function () {
    $category = Category::create(['name' => 'Science', 'code' => 'SCI']);
    $book = Book::create([
        'title' => 'Sapiens',
        'author' => 'Yuval Noah Harari',
        'isbn' => '978-0062316097',
        'category_id' => $category->id,
        'total_copies' => 2,
        'available_copies' => 1,
    ]);

    $member = Member::create([
        'member_number' => 'LIB-OVERDUE-01',
        'name' => 'Overdue Member',
        'email' => 'overdue@example.com',
        'status' => 'active',
    ]);

    // Create overdue loan (due 5 days ago)
    Loan::create([
        'book_id' => $book->id,
        'member_id' => $member->id,
        'loan_date' => Carbon::now()->subDays(12)->toDateString(),
        'due_date' => Carbon::now()->subDays(5)->toDateString(),
        'return_date' => null,
        'status' => 'overdue',
        'fine_amount' => 10000.00,
    ]);

    $action = app(GetOverdueLoansAction::class);
    $overdueLoans = $action->execute();

    expect($overdueLoans->count())->toBe(1);
    expect($action->count())->toBe(1);
    expect($overdueLoans->first()->days_late)->toBe(5);
});
