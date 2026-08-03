<?php

namespace App\Actions\Category;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Gate;

class DeleteCategoryAction
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository
    ) {}

    public function execute(int $id): bool
    {
        $category = $this->categoryRepository->findById($id);
        Gate::authorize('delete', $category);

        $booksCount = $category->books()->count();
        if ($booksCount > 0) {
            throw new Exception("Kategori '{$category->name}' masih digunakan oleh {$booksCount} buku. Anda tidak dapat menghapus kategori ini sampai seluruh buku dipindahkan ke kategori lain.");
        }

        return $this->categoryRepository->delete($id);
    }
}
