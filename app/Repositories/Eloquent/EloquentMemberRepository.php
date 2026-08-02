<?php

namespace App\Repositories\Eloquent;

use App\Models\Member;
use App\Repositories\Contracts\MemberRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class EloquentMemberRepository
 *
 * Implementasi Eloquent dari MemberRepositoryInterface.
 * Kueri database dioptimasi dengan indeks pada 'member_number' dan unik email.
 */
class EloquentMemberRepository implements MemberRepositoryInterface
{
    public function all(): Collection
    {
        return Member::where('status', 'active')->orderBy('name')->get();
    }

    public function paginate(int $perPage = 10, ?string $search = null, ?string $type = null): LengthAwarePaginator
    {
        $query = Member::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('member_number', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if (!empty($type)) {
            $query->where('member_type', $type);
        }

        return $query->latest('id')->paginate($perPage);
    }

    public function findById(int $id): Member
    {
        return Member::findOrFail($id);
    }

    public function findByMemberNumber(string $memberNumber): ?Member
    {
        return Member::where('member_number', $memberNumber)->first();
    }

    public function create(array $data): Member
    {
        if (empty($data['joined_at'])) {
            $data['joined_at'] = now();
        }

        return Member::create($data);
    }

    public function update(int $id, array $data): Member
    {
        $member = $this->findById($id);
        $member->update($data);
        return $member->fresh();
    }

    public function delete(int $id): bool
    {
        $member = $this->findById($id);
        return $member->delete();
    }

    public function getTotalCount(): int
    {
        return Member::count();
    }

    public function getActiveCount(): int
    {
        return Member::where('status', 'active')->count();
    }
}
