<?php

use App\Actions\Book\ImportBooksFromCsvAction;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('books can be imported from csv and duplicates skipped', function () {
    $action = app(ImportBooksFromCsvAction::class);
    $csvPath = base_path('public/dataset/Books2.csv');

    $res1 = $action->execute($csvPath);

    expect($res1['imported'])->toBeGreaterThan(0);
    expect($res1['skipped'])->toBe(0);

    // Second import should skip all duplicates
    $res2 = $action->execute($csvPath);
    expect($res2['imported'])->toBe(0);
    expect($res2['skipped'])->toBe($res1['imported']);
});
