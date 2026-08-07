<?php

namespace App\Repositories\Eloquent;

use App\Models\Genre;
use App\Repositories\Contracts\GenreRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class EloquentGenreRepository implements GenreRepositoryInterface
{
    public function all(): Collection
    {
        return Genre::orderBy('name', 'asc')->get();
    }

    public function paginate(int $perPage = 15, ?string $search = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = Genre::withCount('books');

        if (!empty($search)) {
            $query->where('name', 'like', "%{$search}%");
        }

        return $query->orderBy('name', 'asc')->paginate($perPage);
    }

    public function findById(int $id): Genre
    {
        return Genre::findOrFail($id);
    }

    public function create(array $data): Genre
    {
        if (empty($data['slug']) && isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        return Genre::create($data);
    }

    public function update(int $id, array $data): Genre
    {
        $genre = $this->findById($id);

        if (isset($data['name']) && empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $genre->update($data);
        return $genre;
    }

    public function delete(int $id): bool
    {
        $genre = $this->findById($id);
        return (bool) $genre->delete();
    }
}
