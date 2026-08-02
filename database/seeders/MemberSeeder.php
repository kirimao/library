<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            ['member_number' => 'LIB-2026-0001', 'name' => 'Budi Santoso', 'email' => 'budi.santoso@gmail.com', 'phone' => '081234567890', 'member_type' => 'SD', 'status' => 'active', 'joined_at' => '2026-01-10'],
            ['member_number' => 'LIB-2026-0002', 'name' => 'Siti Rahma', 'email' => 'siti.rahma@yahoo.com', 'phone' => '081298765432', 'member_type' => 'SMP', 'status' => 'active', 'joined_at' => '2026-01-15'],
            ['member_number' => 'LIB-2026-0003', 'name' => 'Dr. Hendra Gunawan', 'email' => 'hendra.gunawan@univ.ac.id', 'phone' => '081311223344', 'member_type' => 'Guru', 'status' => 'active', 'joined_at' => '2026-02-01'],
            ['member_number' => 'LIB-2026-0004', 'name' => 'Dewi Lestari', 'email' => 'dewi.lestari@gmail.com', 'phone' => '081566778899', 'member_type' => 'SMA', 'status' => 'active', 'joined_at' => '2026-02-12'],
            ['member_number' => 'LIB-2026-0005', 'name' => 'Rizky Pratama', 'email' => 'rizky.pratama@outlook.com', 'phone' => '081799887766', 'member_type' => 'Mahasiswa', 'status' => 'active', 'joined_at' => '2026-03-05'],
            ['member_number' => 'LIB-2026-0006', 'name' => 'Ahmad Fauzi, M.T.', 'email' => 'ahmad.fauzi@school.sch.id', 'phone' => '081822334455', 'member_type' => 'Guru', 'status' => 'active', 'joined_at' => '2026-03-20'],
            ['member_number' => 'LIB-2026-0007', 'name' => 'Anisa Putri', 'email' => 'anisa.putri@gmail.com', 'phone' => '081944556677', 'member_type' => 'SD', 'status' => 'active', 'joined_at' => '2026-04-02'],
            ['member_number' => 'LIB-2026-0008', 'name' => 'Bambang Wijaya', 'email' => 'bambang.w@gmail.com', 'phone' => '082133445566', 'member_type' => 'Lainnya', 'status' => 'active', 'joined_at' => '2026-04-18'],
            ['member_number' => 'LIB-2026-0009', 'name' => 'Maya Kartika', 'email' => 'maya.k@yahoo.com', 'phone' => '082255667788', 'member_type' => 'SMP', 'status' => 'active', 'joined_at' => '2026-05-01'],
            ['member_number' => 'LIB-2026-0010', 'name' => 'Doni Setiawan', 'email' => 'doni.setiawan@gmail.com', 'phone' => '082366778899', 'member_type' => 'SMA', 'status' => 'active', 'joined_at' => '2026-05-15'],
        ];

        foreach ($members as $m) {
            Member::firstOrCreate(['member_number' => $m['member_number']], $m);
        }
    }
}
