<?php

use App\Actions\Genre\CreateGenreAction;
use App\Actions\Genre\DeleteGenreAction;
use App\Actions\Loan\AddBookReviewAction;
use App\Actions\Loan\ReturnBookAction;
use App\Actions\Member\GetMemberFavoriteGenreAction;
use App\Models\Book;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Loan;
use App\Models\Member;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;

test('librarian can create genre but cannot delete genre', function () {
    $librarian = User::factory()->create(['role' => 'librarian']);
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($librarian);

    $createAction = app(CreateGenreAction::class);
    $genre = $createAction->execute(['name' => 'Kategori Komik']);

    expect($genre)->not->toBeNull();
    expect($genre->name)->toBe('Kategori Komik');

    $deleteAction = app(DeleteGenreAction::class);

    // Librarian attempting to delete should throw AuthorizationException
    expect(fn () => $deleteAction->execute($genre->id))
        ->toThrow(AuthorizationException::class);

    // Admin can delete
    $this->actingAs($admin);
    $result = $deleteAction->execute($genre->id);
    expect($result)->toBeTrue();
});

test('returning a book updates reading_status and creates review comment', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);

    $category = Category::create(['name' => 'Fiksi', 'code' => 'FIC_TEST']);
    $genre = Genre::create(['name' => 'Fantasi', 'slug' => 'fantasi']);

    $book = Book::create([
        'title' => 'Buku Fantasi',
        'author' => 'Penulis X',
        'isbn' => '978-9999888777',
        'category_id' => $category->id,
        'total_copies' => 3,
        'available_copies' => 2,
    ]);
    $book->genres()->attach($genre->id);

    $member = Member::create([
        'member_number' => 'LIB-TEST-01',
        'name' => 'Siswa SD Test',
        'email' => 'sd@test.com',
        'member_type' => 'SD',
        'status' => 'active',
        'joined_at' => now(),
    ]);

    $loan = Loan::create([
        'book_id' => $book->id,
        'member_id' => $member->id,
        'loan_date' => now()->subDays(5),
        'due_date' => now()->addDays(2),
        'status' => 'borrowed',
        'reading_status' => 'sedang_dibaca',
    ]);

    $returnAction = app(ReturnBookAction::class);
    $returnedLoan = $returnAction->execute(
        $loan->id,
        now()->toDateString(),
        'selesai_dibaca',
        'Buku ini sangat bagus!'
    );

    expect($returnedLoan->status)->toBe('returned');
    expect($returnedLoan->reading_status)->toBe('selesai_dibaca');
    expect($book->fresh()->available_copies)->toBe(3);

    expect($returnedLoan->review)->not->toBeNull();
    expect($returnedLoan->review->comment)->toBe('Buku ini sangat bagus!');

    // Test favorite genre calculation
    $favGenreAction = app(GetMemberFavoriteGenreAction::class);
    $favGenre = $favGenreAction->execute($member->id);

    expect($favGenre)->not->toBeNull();
    expect($favGenre->id)->toBe($genre->id);
});
