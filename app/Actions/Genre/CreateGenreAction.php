<?php

namespace App\Actions\Genre;

use App\Models\Genre;
use App\Repositories\Contracts\GenreRepositoryInterface;
use Illuminate\Support\Facades\Gate;

class CreateGenreAction
{
    public function __construct(
        protected GenreRepositoryInterface $genreRepository
    ) {}

    public function execute(array $data): Genre
    {
        Gate::authorize('create', Genre::class);
        return $this->genreRepository->create($data);
    }
}
