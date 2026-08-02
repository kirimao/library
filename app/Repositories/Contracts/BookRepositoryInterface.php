<?php

namespace App\Repositories\Contracts;

use App\Models\Book;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface BookRepositoryInterface
 */
interface BookRepositoryInterface
{
    public function all(array $relations = []): Collection;
    public function paginate(int $perPage = 10, ?string $search = null, ?int $categoryId = null, ?int $genreId = null): LengthAwarePaginator;
    public function findById(int $id): Book;
    public function findByIsbn(string $isbn): ?Book;
    public function create(array $data, array $genreIds = []): Book;
    public function update(int $id, array $data, array $genreIds = []): Book;
    public function delete(int $id): bool;
    public function decrementAvailableCopies(int $id): bool;
    public function incrementAvailableCopies(int $id): bool;
    public function getPopularBooks(int $limit = 5): Collection;
    public function getTotalCount(): int;
    public function syncGenres(int $bookId, array $genreIds): void;
}
