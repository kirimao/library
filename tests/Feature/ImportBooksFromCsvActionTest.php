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

test('csv import correctly parses flexible book prices with dot thousand separators', function () {
    $action = app(ImportBooksFromCsvAction::class);
    
    $tempCsv = tempnam(sys_get_temp_dir(), 'test_csv_') . '.csv';
    $csvContent = "Judul,Pengarang,Penerbit,Kategori,Jenis Cover,Rak,Jumlah,Harga\n" .
                  "Buku Mahal,Penulis A,Penerbit A,Fiksi,Hardback,A1,1,\"1.500.000\"\n" .
                  "Buku Sedang,Penulis B,Penerbit B,Fiksi,Paperback,A2,1,\"30.000\"\n" .
                  "Buku Polos,Penulis C,Penerbit C,Fiksi,Paperback,A3,1,15000\n";
    file_put_contents($tempCsv, $csvContent);

    $res = $action->execute($tempCsv);
    expect($res['imported'])->toBe(3);

    $bukuMahal = Book::where('title', 'Buku Mahal')->first();
    $bukuSedang = Book::where('title', 'Buku Sedang')->first();
    $bukuPolos = Book::where('title', 'Buku Polos')->first();

    expect((float)$bukuMahal->price)->toBe(1500000.0);
    expect((float)$bukuSedang->price)->toBe(30000.0);
    expect((float)$bukuPolos->price)->toBe(15000.0);

    @unlink($tempCsv);
});
