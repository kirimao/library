<?php

namespace App\Actions\Genre;

use App\Models\Genre;
use App\Repositories\Contracts\GenreRepositoryInterface;
use Illuminate\Support\Facades\Gate;

class UpdateGenreAction
{
    public function __construct(
        protected GenreRepositoryInterface $genreRepository
    ) {}

    public function execute(int $id, array $data): Genre
    {
        $genre = $this->genreRepository->findById($id);
        Gate::authorize('update', $genre);
        return $this->genreRepository->update($id, $data);
    }
}
