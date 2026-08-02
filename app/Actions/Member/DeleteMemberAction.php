<?php

namespace App\Actions\Member;

use App\Models\Member;
use App\Repositories\Contracts\LoanRepositoryInterface;
use App\Repositories\Contracts\MemberRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Gate;

/**
 * Class DeleteMemberAction
 */
class DeleteMemberAction
{
    public function __construct(
        protected MemberRepositoryInterface $memberRepository,
        protected LoanRepositoryInterface $loanRepository
    ) {}

    public function execute(int $id): bool
    {
        $member = $this->memberRepository->findById($id);

        Gate::authorize('delete', $member);

        $activeLoans = $this->loanRepository->getActiveLoansForMember($id);
        if ($activeLoans->count() > 0) {
            throw new Exception(__('members.active_loans_error') ?? 'Anggota masih memiliki pinjaman aktif.');
        }

        return $this->memberRepository->delete($id);
    }
}
