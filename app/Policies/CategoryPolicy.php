<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Category $category): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isLibrarian();
    }

    public function update(User $user, Category $category): bool
    {
        return $user->isAdmin() || $user->isLibrarian();
    }

    public function delete(User $user, Category $category): bool
    {
        return $user->isAdmin();
    }
}
