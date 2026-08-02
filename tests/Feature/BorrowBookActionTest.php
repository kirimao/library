<?php

use App\Actions\Loan\BorrowBookAction;
use App\Models\Book;
use App\Models\Category;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a member can borrow an available book successfully', function () {
    $category = Category::create(['name' => 'Technology', 'code' => 'TECH']);
    $book = Book::create([
        'title' => 'Clean Code',
        'author' => 'Robert C. Martin',
        'isbn' => '978-0132350884',
        'category_id' => $category->id,
        'total_copies' => 3,
        'available_copies' => 3,
    ]);

    $member = Member::create([
        'member_number' => 'LIB-TEST-001',
        'name' => 'Test User',
        'email' => 'test@example.com',
        'status' => 'active',
    ]);

    $action = app(BorrowBookAction::class);
    $loan = $action->execute($member->id, $book->id);

    expect($loan)->not->toBeNull();
    expect($loan->status)->toBe('borrowed');
    expect($book->fresh()->available_copies)->toBe(2);
});

test('a member cannot borrow an out of stock book', function () {
    $category = Category::create(['name' => 'Technology', 'code' => 'TECH']);
    $book = Book::create([
        'title' => 'Clean Code',
        'author' => 'Robert C. Martin',
        'isbn' => '978-0132350884',
        'category_id' => $category->id,
        'total_copies' => 1,
        'available_copies' => 0,
    ]);

    $member = Member::create([
        'member_number' => 'LIB-TEST-002',
        'name' => 'Test User 2',
        'email' => 'test2@example.com',
        'status' => 'active',
    ]);

    $action = app(BorrowBookAction::class);
    
    $this->expectException(Exception::class);
    $action->execute($member->id, $book->id);
});
