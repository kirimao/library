<?php

namespace App\Actions\Genre;

use App\Models\Genre;
use App\Repositories\Contracts\GenreRepositoryInterface;
use Illuminate\Support\Facades\Gate;

class DeleteGenreAction
{
    public function __construct(
        protected GenreRepositoryInterface $genreRepository
    ) {}

    public function execute(int $id): bool
    {
        $genre = $this->genreRepository->findById($id);
        Gate::authorize('delete', $genre);
        return $this->genreRepository->delete($id);
    }
}
