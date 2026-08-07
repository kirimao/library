<?php

namespace App\Actions\Member;

use App\Models\Member;
use Illuminate\Support\Facades\Cache;

class PromoteAllMembersAction
{
    /**
     * Promote all eligible student members to the next grade / school level.
     *
     * @return array Summary of promotion
     */
    public function execute(): array
    {
        $members = Member::where('status', 'active')->get();
        $promotedCount = 0;
        $graduatedCount = 0;
        $skippedCount = 0;

        foreach ($members as $member) {
            if (in_array($member->member_type, ['Guru', 'Lainnya']) || in_array($member->grade, ['Alumni', 'Lulus'])) {
                $skippedCount++;
                continue;
            }

            $gradeStr = trim((string) $member->grade);
            preg_match('/\d+/', $gradeStr, $matches);
            $gradeNum = isset($matches[0]) ? (int) $matches[0] : null;

            if ($gradeNum === null) {
                $skippedCount++;
                continue;
            }

            $updated = false;

            if ($member->member_type === 'SD') {
                if ($gradeNum < 5) {
                    $member->grade = 'Kelas ' . ($gradeNum + 1);
                    $updated = true;
                    $promotedCount++;
                } elseif ($gradeNum == 5) {
                    $member->grade = 'Kelas 6';
                    $updated = true;
                    $promotedCount++;
                } elseif ($gradeNum >= 6) {
                    // Graduate SD -> SMP
                    $member->member_type = 'SMP';
                    $member->grade = 'Kelas 1';
                    $updated = true;
                    $promotedCount++;
                }
            } elseif ($member->member_type === 'SMP') {
                if ($gradeNum == 1 || $gradeNum == 7) {
                    $member->grade = 'Kelas 2';
                    $updated = true;
                    $promotedCount++;
                } elseif ($gradeNum == 2 || $gradeNum == 8) {
                    $member->grade = 'Kelas 3';
                    $updated = true;
                    $promotedCount++;
                } elseif ($gradeNum >= 3 || $gradeNum >= 9) {
                    // Graduate SMP -> SMA
                    $member->member_type = 'SMA';
                    $member->grade = 'Kelas 1';
                    $updated = true;
                    $promotedCount++;
                }
            } elseif ($member->member_type === 'SMA') {
                if ($gradeNum == 1 || $gradeNum == 10) {
                    $member->grade = 'Kelas 2';
                    $updated = true;
                    $promotedCount++;
                } elseif ($gradeNum == 2 || $gradeNum == 11) {
                    $member->grade = 'Kelas 3';
                    $updated = true;
                    $promotedCount++;
                } elseif ($gradeNum >= 3 || $gradeNum >= 12) {
                    // Graduate SMA -> Alumni
                    $member->member_type = 'Lainnya';
                    $member->grade = 'Alumni';
                    $member->status = 'inactive';
                    $updated = true;
                    $graduatedCount++;
                }
            }

            if ($updated) {
                $member->save();
            } else {
                $skippedCount++;
            }
        }

        Cache::put('last_mass_promotion_at', now()->toDateTimeString());

        return [
            'promoted' => $promotedCount,
            'graduated' => $graduatedCount,
            'skipped' => $skippedCount,
            'timestamp' => now()->toDateTimeString(),
        ];
    }
}
