<?php

namespace App\Repositories\Contracts;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Collection;

interface GenreRepositoryInterface
{
    public function all(): Collection;
    public function findById(int $id): Genre;
    public function create(array $data): Genre;
    public function update(int $id, array $data): Genre;
    public function delete(int $id): bool;
}
