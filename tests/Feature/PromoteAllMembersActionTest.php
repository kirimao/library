<?php

use App\Actions\Member\PromoteAllMembersAction;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('students are promoted mass grade levels', function () {
    $sd1 = Member::create([
        'name' => 'Siswa SD 1',
        'member_number' => 'M-001',
        'member_type' => 'SD',
        'grade' => 'Kelas 1',
        'status' => 'active',
    ]);

    $sd5 = Member::create([
        'name' => 'Siswa SD 5',
        'member_number' => 'M-005',
        'member_type' => 'SD',
        'grade' => 'Kelas 5',
        'status' => 'active',
    ]);

    $action = app(PromoteAllMembersAction::class);
    $result = $action->execute();

    expect($sd1->fresh()->grade)->toBe('Kelas 2');
    expect($sd5->fresh()->grade)->toBe('Kelas 6');
    expect($result['promoted'])->toBe(2);
});
