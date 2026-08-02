<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class EloquentCategoryRepository
 *
 * Implementasi konkret dari CategoryRepositoryInterface menggunakan Eloquent ORM.
 * Bertanggung jawab melakukan query langsung ke tabel 'categories'.
 */
class EloquentCategoryRepository implements CategoryRepositoryInterface
{
    public function all(): Collection
    {
        return Category::orderBy('name')->get();
    }

    public function findById(int $id)
    {
        return Category::findOrFail($id);
    }
}
