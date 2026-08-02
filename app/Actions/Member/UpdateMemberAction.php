<?php

namespace App\Actions\Member;

use App\Models\Member;
use App\Repositories\Contracts\MemberRepositoryInterface;

/**
 * Class UpdateMemberAction
 *
 * Single Responsibility Action Class untuk memperbarui data anggota.
 */
class UpdateMemberAction
{
    public function __construct(
        protected MemberRepositoryInterface $memberRepository
    ) {}

    /**
     * Eksekusi pembaruan data profil anggota.
     *
     * @param int $id ID anggota
     * @param array $data Data perubahan
     * @return Member
     */
    public function execute(int $id, array $data): Member
    {
        return $this->memberRepository->update($id, $data);
    }
}
