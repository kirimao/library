<?php

namespace App\Repositories\Contracts;

use App\Models\Member;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface MemberRepositoryInterface
 *
 * Abstraksi data layer untuk manajemen Anggota Perpustakaan.
 */
interface MemberRepositoryInterface
{
    public function all(): Collection;
    public function paginate(int $perPage = 10, ?string $search = null, ?string $type = null, ?string $grade = null): LengthAwarePaginator;
    public function findById(int $id): Member;
    public function findByMemberNumber(string $memberNumber): ?Member;
    public function create(array $data): Member;
    public function update(int $id, array $data): Member;
    public function delete(int $id): bool;
    public function getTotalCount(): int;
    public function getActiveCount(): int;
}
