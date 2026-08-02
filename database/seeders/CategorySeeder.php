<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Pemrograman & Teknologi', 'code' => 'TECH'],
            ['name' => 'Fiksi & Novel', 'code' => 'FIC'],
            ['name' => 'Sains & Matematika', 'code' => 'SCI'],
            ['name' => 'Sejarah & Budaya', 'code' => 'HIST'],
            ['name' => 'Bisnis & Ekonomi', 'code' => 'BUS'],
            ['name' => 'Pengembangan Diri', 'code' => 'SELF'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['code' => $cat['code']], $cat);
        }
    }
}
