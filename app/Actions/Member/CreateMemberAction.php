<?php

namespace App\Actions\Member;

use App\Models\Member;
use App\Repositories\Contracts\MemberRepositoryInterface;

/**
 * Class CreateMemberAction
 *
 * Single Responsibility Action Class untuk me-registrasi anggota baru perpustakaan.
 * Bertanggung jawab atas otomasi pembuatan Nomor Anggota (jika belum diisi) dan pengisian tanggal bergabung.
 */
class CreateMemberAction
{
    public function __construct(
        protected MemberRepositoryInterface $memberRepository
    ) {}

    /**
     * Eksekusi pendaftaran anggota baru.
     *
     * @param array $data Data pendaftaran anggota
     * @return Member
     */
    public function execute(array $data): Member
    {
        // Generate nomor anggota unik jika tidak disertakan (format: LIB-YYYYMM-XXXX)
        if (empty($data['member_number'])) {
            $prefix = 'LIB-' . date('Ym') . '-';
            $data['member_number'] = $prefix . str_pad((string) rand(1, 9999), 4, '0', STR_PAD_LEFT);
        }

        if (empty($data['joined_at'])) {
            $data['joined_at'] = now()->toDateString();
        }

        return $this->memberRepository->create($data);
    }
}
