<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Genre;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $tech = Category::where('code', 'TECH')->first()->id;
        $fic = Category::where('code', 'FIC')->first()->id;
        $sci = Category::where('code', 'SCI')->first()->id;
        $hist = Category::where('code', 'HIST')->first()->id;
        $bus = Category::where('code', 'BUS')->first()->id;
        $self = Category::where('code', 'SELF')->first()->id;

        $genres = Genre::all();

        $books = [
            [
                'title' => 'Clean Code: A Handbook of Agile Software Craftsmanship',
                'author' => 'Robert C. Martin',
                'isbn' => '978-0132350884',
                'category_id' => $tech,
                'publisher' => 'Prentice Hall',
                'year' => 2008,
                'arrival_month' => 8,
                'arrival_year' => 2023,
                'total_copies' => 5,
                'available_copies' => 5,
                'shelf_location' => 'Rak A-01',
                'genres' => ['Informatika', 'Teknologi'],
            ],
            [
                'title' => 'Design Patterns: Elements of Reusable Object-Oriented Software',
                'author' => 'Erich Gamma et al.',
                'isbn' => '978-0201633610',
                'category_id' => $tech,
                'publisher' => 'Addison-Wesley',
                'year' => 1994,
                'arrival_month' => 1,
                'arrival_year' => 2024,
                'total_copies' => 4,
                'available_copies' => 4,
                'shelf_location' => 'Rak A-01',
                'genres' => ['Informatika', 'Teknologi'],
            ],
            [
                'title' => 'Laravel Up & Running',
                'author' => 'Matt Stauffer',
                'isbn' => '978-1492041214',
                'category_id' => $tech,
                'publisher' => "O'Reilly Media",
                'year' => 2019,
                'arrival_month' => 2,
                'arrival_year' => 2025,
                'total_copies' => 6,
                'available_copies' => 4,
                'shelf_location' => 'Rak A-02',
                'genres' => ['Informatika', 'Teknologi'],
            ],
            [
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'isbn' => '978-9793062792',
                'category_id' => $fic,
                'publisher' => 'Bentang Pustaka',
                'year' => 2005,
                'arrival_month' => 6,
                'arrival_year' => 2022,
                'total_copies' => 8,
                'available_copies' => 6,
                'shelf_location' => 'Rak B-01',
                'genres' => ['Petualangan', 'Biografi'],
            ],
            [
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'isbn' => '978-9799731235',
                'category_id' => $fic,
                'publisher' => 'Lentera Dipantara',
                'year' => 1980,
                'arrival_month' => 11,
                'arrival_year' => 2023,
                'total_copies' => 5,
                'available_copies' => 3,
                'shelf_location' => 'Rak B-01',
                'genres' => ['Sejarah', 'Biografi', 'Romance'],
            ],
            [
                'title' => 'Cantik Itu Luka',
                'author' => 'Eka Kurniawan',
                'isbn' => '978-6020312583',
                'category_id' => $fic,
                'publisher' => 'Gramedia Pustaka Utama',
                'year' => 2002,
                'arrival_month' => 4,
                'arrival_year' => 2024,
                'total_copies' => 4,
                'available_copies' => 2,
                'shelf_location' => 'Rak B-02',
                'genres' => ['Romance', 'Misteri'],
            ],
            [
                'title' => 'Sapiens: A Brief History of Humankind',
                'author' => 'Yuval Noah Harari',
                'isbn' => '978-0062316097',
                'category_id' => $sci,
                'publisher' => 'Harper',
                'year' => 2014,
                'arrival_month' => 1,
                'arrival_year' => 2025,
                'total_copies' => 7,
                'available_copies' => 5,
                'shelf_location' => 'Rak C-01',
                'genres' => ['Sains', 'Sejarah', 'Ensiklopedia'],
            ],
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'isbn' => '978-0735211292',
                'category_id' => $self,
                'publisher' => 'Avery',
                'year' => 2018,
                'arrival_month' => 3,
                'arrival_year' => 2025,
                'total_copies' => 10,
                'available_copies' => 7,
                'shelf_location' => 'Rak F-01',
                'genres' => ['Pengembangan Diri', 'Biografi'],
            ],
        ];

        foreach ($books as $b) {
            $genreNames = $b['genres'];
            unset($b['genres']);

            $book = Book::updateOrCreate(['isbn' => $b['isbn']], $b);

            $genreIds = Genre::whereIn('name', $genreNames)->pluck('id')->toArray();
            $book->genres()->sync($genreIds);
        }
    }
}
