<?php

namespace App\Policies;

use App\Models\Genre;
use App\Models\User;

class GenrePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Genre $genre): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isLibrarian();
    }

    public function update(User $user, Genre $genre): bool
    {
        return $user->isAdmin() || $user->isLibrarian();
    }

    public function delete(User $user, Genre $genre): bool
    {
        return $user->isAdmin();
    }
}
