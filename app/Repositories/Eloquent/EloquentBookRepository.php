<?php

namespace App\Repositories\Eloquent;

use App\Models\Book;
use App\Repositories\Contracts\BookRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class EloquentBookRepository
 */
class EloquentBookRepository implements BookRepositoryInterface
{
    public function all(array $relations = []): Collection
    {
        return Book::with($relations)->orderBy('title')->get();
    }

    public function paginate(int $perPage = 10, ?string $search = null, ?int $categoryId = null, ?int $genreId = null, ?string $arrivalStatus = null, ?int $arrivalYear = null): LengthAwarePaginator
    {
        $query = Book::with(['category', 'genres']);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        if (!empty($genreId)) {
            $query->whereHas('genres', function ($q) use ($genreId) {
                $q->where('genres.id', $genreId);
            });
        }

        if (!empty($arrivalStatus)) {
            if ($arrivalStatus === 'baru') {
                $query->where('arrival_year', '>=', 2025);
            } elseif ($arrivalStatus === 'lama') {
                $query->where(function ($q) {
                    $q->whereNull('arrival_year')
                      ->orWhere('arrival_year', '<', 2025);
                });
            }
        }

        if (!empty($arrivalYear)) {
            $query->where('arrival_year', $arrivalYear);
        }

        return $query->latest('id')->paginate($perPage);
    }

    public function findById(int $id): Book
    {
        return Book::with(['category', 'genres', 'reviews.member'])->findOrFail($id);
    }

    public function findByIsbn(string $isbn): ?Book
    {
        return Book::where('isbn', $isbn)->first();
    }

    public function create(array $data, array $genreIds = []): Book
    {
        if (!isset($data['available_copies'])) {
            $data['available_copies'] = $data['total_copies'] ?? 1;
        }

        $book = Book::create($data);

        if (!empty($genreIds)) {
            $book->genres()->sync($genreIds);
        }

        return $book->load('genres');
    }

    public function update(int $id, array $data, array $genreIds = []): Book
    {
        $book = $this->findById($id);

        if (isset($data['total_copies']) && $data['total_copies'] != $book->total_copies && !isset($data['available_copies'])) {
            $diff = $data['total_copies'] - $book->total_copies;
            $data['available_copies'] = max(0, $book->available_copies + $diff);
        }

        $book->update($data);

        if (isset($genreIds)) {
            $book->genres()->sync($genreIds);
        }

        return $book->fresh(['category', 'genres']);
    }

    public function syncGenres(int $bookId, array $genreIds): void
    {
        $book = $this->findById($bookId);
        $book->genres()->sync($genreIds);
    }

    public function delete(int $id): bool
    {
        $book = $this->findById($id);
        return $book->delete();
    }

    public function decrementAvailableCopies(int $id): bool
    {
        $book = $this->findById($id);
        if ($book->available_copies > 0) {
            return $book->decrement('available_copies') > 0;
        }
        return false;
    }

    public function incrementAvailableCopies(int $id): bool
    {
        $book = $this->findById($id);
        if ($book->available_copies < $book->total_copies) {
            return $book->increment('available_copies') > 0;
        }
        return false;
    }

    public function getPopularBooks(int $limit = 5): Collection
    {
        return Book::withCount('loans')
            ->orderBy('loans_count', 'desc')
            ->take($limit)
            ->get();
    }

    public function getTotalCount(): int
    {
        return Book::count();
    }
}
