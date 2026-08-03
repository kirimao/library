<?php

namespace App\Actions\Category;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Gate;

class UpdateCategoryAction
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository
    ) {}

    public function execute(int $id, array $data): Category
    {
        $category = $this->categoryRepository->findById($id);
        Gate::authorize('update', $category);
        return $this->categoryRepository->update($id, $data);
    }
}
