<?php

namespace App\Actions\Category;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Gate;

class CreateCategoryAction
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository
    ) {}

    public function execute(array $data): Category
    {
        Gate::authorize('create', Category::class);
        return $this->categoryRepository->create($data);
    }
}
