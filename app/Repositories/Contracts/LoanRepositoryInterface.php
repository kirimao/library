<?php

namespace App\Repositories\Contracts;

use App\Models\Genre;
use App\Models\Loan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface LoanRepositoryInterface
 *
 * Abstraksi data layer untuk Peminjaman dan Pengembalian Buku.
 */
interface LoanRepositoryInterface
{
    public function paginate(int $perPage = 10, ?string $status = null, ?string $search = null): LengthAwarePaginator;
    public function findById(int $id): Loan;
    public function create(array $data): Loan;
    public function update(int $id, array $data): Loan;
    public function getOverdueLoans(): Collection;
    public function getOverdueLoansPaginated(int $perPage = 15, ?string $search = null): LengthAwarePaginator;
    public function getOverdueLoansCount(): int;
    public function getActiveLoansForMember(int $memberId): Collection;
    public function getHistoryForMember(int $memberId): Collection;
    public function hasActiveLoanForBook(int $memberId, int $bookId): bool;
    public function getActiveLoansCount(): int;
    public function getRecentLoans(int $limit = 5): Collection;

    // Phase 2 Methods
    public function getReadersForBook(int $bookId): Collection;
    public function getPopularGenres(?string $memberType = null, int $limit = 10): Collection;
    public function getMostReadBooks(?int $genreId = null, ?string $memberType = null, int $limit = 10): Collection;
    public function getFavoriteGenreForMember(int $memberId): ?Genre;
    public function updateReadingStatus(int $loanId, string $status): Loan;
}
