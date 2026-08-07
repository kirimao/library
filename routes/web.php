<?php

use App\Livewire\Books\BookDetail;
use App\Livewire\Books\BookIndex;
use App\Livewire\Dashboard;
use App\Livewire\Genres\GenreManager;
use App\Livewire\LandingPage;
use App\Livewire\Loans\LoanForm;
use App\Livewire\Loans\OverdueList;
use App\Livewire\Loans\ReturnForm;
use App\Livewire\LoginLogIndex;
use App\Livewire\Members\MemberIndex;
use App\Livewire\Members\MemberProfile;
use App\Livewire\Reports\PopularReports;
use Illuminate\Support\Facades\Route;

// Landing page & Guest Catalog publik — accessible tanpa login
Route::get('/', LandingPage::class)->name('landing');
Route::get('/catalog', \App\Livewire\GuestCatalog::class)->name('catalog');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/categories', \App\Livewire\Categories\CategoryManager::class)->name('categories.index');
    Route::get('/genres', GenreManager::class)->name('genres.index');
    Route::get('/books', BookIndex::class)->name('books.index');
    Route::get('/books/import', \App\Livewire\Books\ImportBooks::class)->name('books.import');
    Route::get('/books/{id}', BookDetail::class)->name('books.show');

    Route::get('/members', MemberIndex::class)->name('members.index');
    Route::get('/members/promote', \App\Livewire\Members\PromoteMembers::class)->name('members.promote');
    Route::get('/members/{id}', MemberProfile::class)->name('members.show');

    Route::get('/loans/create', LoanForm::class)->name('loans.create');
    Route::get('/loans/return', ReturnForm::class)->name('loans.return');
    Route::get('/loans/overdue', OverdueList::class)->name('loans.overdue');

    Route::get('/reports/popular', PopularReports::class)->name('reports.popular');

    // Log Login — hanya admin
    Route::get('/login-logs', LoginLogIndex::class)->name('login-logs.index');
    Route::get('/users', \App\Livewire\Users\UserManager::class)->name('users.index');

    Route::view('profile', 'profile')->name('profile');
});

require __DIR__.'/auth.php';

