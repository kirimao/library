<?php

namespace App\Actions\Genre;

use App\Models\Genre;
use App\Repositories\Contracts\GenreRepositoryInterface;
use Exception;
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

        $booksCount = $genre->books()->count();
        if ($booksCount > 0) {
            throw new Exception("Genre '{$genre->name}' masih digunakan oleh {$booksCount} buku. Anda tidak dapat menghapus genre ini sampai seluruh buku dipindahkan dari genre ini.");
        }

        return $this->genreRepository->delete($id);
    }
}
