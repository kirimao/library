<?php

namespace App\Actions\Member;

use App\Models\Member;

class AdjustMemberGradeAction
{
    /**
     * Manually adjust a member's grade and level.
     *
     * @param int $memberId
     * @param string $memberType
     * @param string|null $grade
     * @param string $status
     * @return Member
     */
    public function execute(int $memberId, string $memberType, ?string $grade, string $status = 'active'): Member
    {
        $member = Member::findOrFail($memberId);
        $member->update([
            'member_type' => $memberType,
            'grade' => $grade,
            'status' => $status,
        ]);

        return $member->fresh();
    }
}
