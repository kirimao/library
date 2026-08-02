<?php

namespace App\Repositories\Eloquent;

use App\Models\Genre;
use App\Models\Loan;
use App\Repositories\Contracts\LoanRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class EloquentLoanRepository
 */
class EloquentLoanRepository implements LoanRepositoryInterface
{
    public function paginate(int $perPage = 10, ?string $status = null, ?string $search = null): LengthAwarePaginator
    {
        $query = Loan::with(['book', 'member']);

        if (!empty($status)) {
            $query->where('status', $status);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('book', function ($bq) use ($search) {
                    $bq->where('title', 'like', "%{$search}%")
                       ->orWhere('isbn', 'like', "%{$search}%");
                })->orWhereHas('member', function ($mq) use ($search) {
                    $mq->where('name', 'like', "%{$search}%")
                       ->orWhere('member_number', 'like', "%{$search}%");
                });
            });
        }

        return $query->latest('id')->paginate($perPage);
    }

    public function findById(int $id): Loan
    {
        return Loan::with(['book', 'member', 'review'])->findOrFail($id);
    }

    public function create(array $data): Loan
    {
        return Loan::create($data);
    }

    public function update(int $id, array $data): Loan
    {
        $loan = $this->findById($id);
        $loan->update($data);
        return $loan->fresh(['book', 'member']);
    }

    public function updateReadingStatus(int $loanId, string $status): Loan
    {
        $loan = $this->findById($loanId);
        $loan->update(['reading_status' => $status]);
        return $loan;
    }

    public function getOverdueLoans(): Collection
    {
        $today = Carbon::today()->toDateString();

        return Loan::with(['book', 'member'])
            ->where(function ($q) use ($today) {
                $q->where('status', 'overdue')
                  ->orWhere(function ($sq) use ($today) {
                      $sq->where('status', 'borrowed')
                         ->where('due_date', '<', $today);
                  });
            })
            ->orderBy('due_date', 'asc')
            ->get();
    }

    public function getOverdueLoansCount(): int
    {
        $today = Carbon::today()->toDateString();

        return Loan::where(function ($q) use ($today) {
            $q->where('status', 'overdue')
              ->orWhere(function ($sq) use ($today) {
                  $sq->where('status', 'borrowed')
                     ->where('due_date', '<', $today);
              });
        })->count();
    }

    public function getActiveLoansForMember(int $memberId): Collection
    {
        return Loan::with('book')
            ->where('member_id', $memberId)
            ->whereIn('status', ['borrowed', 'overdue'])
            ->get();
    }

    public function getHistoryForMember(int $memberId): Collection
    {
        return Loan::with(['book.genres', 'review'])
            ->where('member_id', $memberId)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function hasActiveLoanForBook(int $memberId, int $bookId): bool
    {
        return Loan::where('member_id', $memberId)
            ->where('book_id', $bookId)
            ->whereIn('status', ['borrowed', 'overdue'])
            ->exists();
    }

    public function getActiveLoansCount(): int
    {
        return Loan::whereIn('status', ['borrowed', 'overdue'])->count();
    }

    public function getRecentLoans(int $limit = 5): Collection
    {
        return Loan::with(['book', 'member'])
            ->latest('id')
            ->take($limit)
            ->get();
    }

    public function getReadersForBook(int $bookId): Collection
    {
        return Loan::with(['member', 'review'])
            ->where('book_id', $bookId)
            ->orderBy('loan_date', 'desc')
            ->get();
    }

    public function getPopularGenres(?string $memberType = null, int $limit = 10): Collection
    {
        $query = Genre::query()
            ->select('genres.*', DB::raw('COUNT(loans.id) as loans_count'))
            ->join('book_genre', 'genres.id', '=', 'book_genre.genre_id')
            ->join('loans', 'book_genre.book_id', '=', 'loans.book_id');

        if (!empty($memberType)) {
            $query->join('members', 'loans.member_id', '=', 'members.id')
                  ->where('members.member_type', $memberType);
        }

        return $query->groupBy('genres.id', 'genres.name', 'genres.slug', 'genres.created_at', 'genres.updated_at')
            ->orderBy('loans_count', 'desc')
            ->take($limit)
            ->get();
    }

    public function getMostReadBooks(?int $genreId = null, ?string $memberType = null, int $limit = 10): Collection
    {
        $query = DB::table('books')
            ->select('books.*', DB::raw('COUNT(loans.id) as loans_count'))
            ->join('loans', 'books.id', '=', 'loans.book_id');

        if (!empty($genreId)) {
            $query->join('book_genre', 'books.id', '=', 'book_genre.book_id')
                  ->where('book_genre.genre_id', $genreId);
        }

        if (!empty($memberType)) {
            $query->join('members', 'loans.member_id', '=', 'members.id')
                  ->where('members.member_type', $memberType);
        }

        $results = $query->groupBy('books.id', 'books.title', 'books.author', 'books.isbn', 'books.category_id', 'books.publisher', 'books.year', 'books.total_copies', 'books.available_copies', 'books.shelf_location', 'books.created_at', 'books.updated_at')
            ->orderBy('loans_count', 'desc')
            ->take($limit)
            ->get();

        return Collection::make($results);
    }

    public function getFavoriteGenreForMember(int $memberId): ?Genre
    {
        $genreId = DB::table('loans')
            ->join('book_genre', 'loans.book_id', '=', 'book_genre.book_id')
            ->where('loans.member_id', $memberId)
            ->select('book_genre.genre_id', DB::raw('COUNT(*) as total'))
            ->groupBy('book_genre.genre_id')
            ->orderBy('total', 'desc')
            ->value('genre_id');

        if (!$genreId) {
            return null;
        }

        return Genre::find($genreId);
    }
}
