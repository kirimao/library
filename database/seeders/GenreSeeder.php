<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            'Romance',
            'Komik',
            'Petualangan',
            'Sains',
            'Fantasi',
            'Misteri',
            'Ensiklopedia',
            'Dongeng',
            'Informatika',
            'Biografi',
            'Pengembangan Diri',
            'Teknologi',
            'Bisnis',
            'Sejarah',
        ];

        foreach ($genres as $name) {
            Genre::firstOrCreate([
                'name' => $name,
            ], [
                'slug' => Str::slug($name),
            ]);
        }
    }
}
