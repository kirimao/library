<?php

namespace App\Actions\Book;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\UploadedFile;

class ImportBooksFromCsvAction
{
    /**
     * Import books from a CSV file.
     *
     * @param UploadedFile|string $file Path or UploadedFile object
     * @return array Summary of import results
     */
    public function execute($file): array
    {
        $filePath = $file instanceof UploadedFile ? $file->getRealPath() : $file;

        if (!file_exists($filePath) || !is_readable($filePath)) {
            return [
                'total' => 0,
                'imported' => 0,
                'skipped' => 0,
                'failed' => 1,
                'errors' => ['File CSV tidak dapat dibaca atau tidak ditemukan.'],
            ];
        }

        $content = file_get_contents($filePath);
        // Normalize line endings
        $content = str_replace(["\r\n", "\r"], "\n", $content);
        $lines = explode("\n", $content);

        $total = 0;
        $imported = 0;
        $skipped = 0;
        $failed = 0;
        $errors = [];
        $lineNum = 0;

        $categoriesCache = Category::all()->pluck('id', 'name')->toArray();
        $bookCounter = Book::max('id') ?? 0;

        foreach ($lines as $rawLine) {
            $lineNum++;
            $line = trim($rawLine);

            if ($line === '') {
                continue;
            }

            // Remove UTF-8 BOM if present
            if ($lineNum === 1) {
                $line = preg_replace('/[\x00-\x1F\x7F\xEF\xBB\xBF]/', '', $line);
            }

            // Check if entire line is enclosed in quotes (common Excel export quirk)
            if (str_starts_with($line, '"') && str_ends_with($line, '"') && strlen($line) > 2) {
                $unwrapped = substr($line, 1, -1);
                $unwrapped = str_replace('""', '"', $unwrapped);
                $row = str_getcsv($unwrapped);
            } else {
                $row = str_getcsv($line);
            }

            if (empty($row) || empty(array_filter($row, fn($val) => trim((string)$val) !== ''))) {
                continue;
            }

            // Skip Header row if detected
            $firstCol = strtolower(trim($row[0] ?? ''));
            if ($lineNum === 1 && (str_contains($firstCol, 'title') || str_contains($firstCol, 'judul'))) {
                continue;
            }

            $total++;

            $title     = trim($row[0] ?? '');
            $author    = trim($row[1] ?? '');
            $publisher = trim($row[2] ?? '');
            $catName   = trim($row[3] ?? '');
            $coverType = trim($row[4] ?? '');
            $shelf     = trim($row[5] ?? '');
            $quantity  = trim($row[6] ?? '');
            $price     = trim($row[7] ?? '');

            // Validation: Fallback if Title is empty
            if (empty($title)) {
                $title = !empty($author) && $author !== 'Anonim' ? "Buku {$author}" : "Buku Tanpa Judul";
            }

            if (empty($author)) {
                $author = 'Anonim';
            }

            if (empty($catName)) {
                $catName = 'Umum';
            }

            // Check duplicate by Title + Author (case-insensitive)
            $existing = Book::whereRaw('LOWER(title) = ?', [strtolower($title)])
                ->whereRaw('LOWER(author) = ?', [strtolower($author)])
                ->exists();

            if ($existing) {
                $skipped++;
                continue;
            }

            // Find or create Category
            if (!isset($categoriesCache[$catName])) {
                $code = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $catName), 0, 4));
                if (empty($code)) {
                    $code = 'CAT';
                }

                $catObj = Category::firstOrCreate(
                    ['name' => $catName],
                    ['code' => $code . rand(10, 99)]
                );
                $categoriesCache[$catName] = $catObj->id;
            }

            $catId = $categoriesCache[$catName];
            $bookCounter++;
            $isbn = 'BK-CSV-' . date('Y') . '-' . str_pad((string) $bookCounter, 5, '0', STR_PAD_LEFT);

            $qtyInt = is_numeric($quantity) && (int)$quantity > 0 ? (int)$quantity : 1;
            $priceNum = is_numeric($price) && (float)$price > 0 ? (float)$price : null;

            Book::create([
                'title' => $title,
                'author' => $author,
                'publisher' => !empty($publisher) ? $publisher : null,
                'category_id' => $catId,
                'cover_type' => !empty($coverType) ? $coverType : null,
                'shelf_location' => !empty($shelf) ? $shelf : null,
                'total_copies' => $qtyInt,
                'available_copies' => $qtyInt,
                'price' => $priceNum,
                'isbn' => $isbn,
                'year' => date('Y'),
                'arrival_month' => (int) date('n'),
                'arrival_year' => (int) date('Y'),
            ]);

            $imported++;
        }

        return [
            'total' => $total,
            'imported' => $imported,
            'skipped' => $skipped,
            'failed' => $failed,
            'errors' => $errors,
        ];
    }
}
