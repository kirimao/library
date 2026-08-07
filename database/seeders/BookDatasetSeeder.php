<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BookDatasetSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = database_path('seeders/books_dataset.json');

        if (!file_exists($jsonPath)) {
            $pyScript = database_path('seeders/parse_books.py');
            exec("python {$pyScript}");
        }

        if (!file_exists($jsonPath)) {
            $this->command?->error("Books dataset JSON file not found.");
            return;
        }

        $booksData = json_decode(file_get_contents($jsonPath), true);
        if (!$booksData) {
            $this->command?->error("Failed to parse books dataset JSON.");
            return;
        }

        $codeMap = [
            'Bilingual' => 'BIL',
            'Reading 1' => 'RD1',
            'Reading 2' => 'RD2',
            'Reading 3' => 'RD3',
            'Reading 4' => 'RD4',
            'Religion' => 'REL',
            'General Knowledge' => 'GK',
            'Comic' => 'CMC',
            'Novel' => 'NVL',
            'Activity Book' => 'ACT',
            'Science' => 'SCI',
            'Math' => 'MTH',
            'Bibliography' => 'BIB',
            'Kindergarten' => 'KDG',
            'Animal' => 'ANM',
            'Comic Islami' => 'CMCI',
            'Ensiklopedia' => 'ENC',
            'Fiksi & Novel' => 'FIC',
            'Pemrograman & Teknologi' => 'TECH',
            'Sains & Matematika' => 'SCI-M',
            'Sejarah & Budaya' => 'HIST',
            'Bisnis & Ekonomi' => 'BUS',
            'Pengembangan Diri' => 'SELF',
        ];

        $categories = [];

        $createdCount = 0;
        $updatedCount = 0;
        $bookCounter = Book::max('id') ?? 0;

        foreach ($booksData as $b) {
            $catName = trim($b['category']);
            
            if (!isset($categories[$catName])) {
                $code = $codeMap[$catName] ?? strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $catName), 0, 4));
                
                // Avoid duplicate codes
                $existingCatWithCode = Category::where('code', $code)->where('name', '!=', $catName)->first();
                if ($existingCatWithCode) {
                    $code = $code . '-' . rand(10, 99);
                }

                $category = Category::firstOrCreate(
                    ['name' => $catName],
                    ['code' => $code]
                );

                $categories[$catName] = $category;
            }

            $catObj = $categories[$catName];
            
            $existing = Book::where('title', $b['title'])
                ->where('author', $b['author'])
                ->first();

            if ($existing) {
                $existing->update([
                    'category_id' => $catObj->id,
                    'publisher' => $b['publisher'],
                ]);
                $updatedCount++;
            } else {
                $bookCounter++;
                $isbn = 'BK-2026-' . str_pad((string) $bookCounter, 5, '0', STR_PAD_LEFT);

                Book::create([
                    'title' => $b['title'],
                    'author' => $b['author'],
                    'publisher' => $b['publisher'],
                    'category_id' => $catObj->id,
                    'isbn' => $isbn,
                    'year' => 2026,
                    'arrival_month' => 1,
                    'arrival_year' => 2026,
                    'total_copies' => 1,
                    'available_copies' => 1,
                    'shelf_location' => 'Rak ' . $catObj->code,
                ]);
                $createdCount++;
            }
        }

        if (isset($this->command)) {
            $this->command->info("Book dataset imported successfully: {$createdCount} created, {$updatedCount} updated.");
        }
    }
}
