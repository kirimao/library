<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;

class StudentDatasetSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = database_path('seeders/students_dataset.json');

        if (!file_exists($jsonPath)) {
            // Generate dynamically via python if available
            $pyScript = database_path('seeders/parse_dataset.py');
            exec("python {$pyScript} > {$jsonPath}");
        }

        if (!file_exists($jsonPath)) {
            $this->command?->error("Dataset JSON file not found.");
            return;
        }

        $allStudents = json_decode(file_get_contents($jsonPath), true);
        if (!$allStudents) {
            $this->command?->error("Failed to parse dataset JSON.");
            return;
        }

        $sdCounter = 100;
        $smpCounter = 100;
        $usedNumbers = Member::pluck('member_number')->toArray();
        $usedNumbersMap = array_flip($usedNumbers);

        $insertedCount = 0;
        $updatedCount = 0;

        foreach ($allStudents as $st) {
            $mType = $st['member_type'];
            $nis = trim($st['nis'] ?? '');

            if (!empty($nis) && is_numeric($nis) && strlen($nis) >= 3) {
                $num = $mType . '-' . str_pad($nis, 4, '0', STR_PAD_LEFT);
            } else {
                if ($mType === 'SD') {
                    $sdCounter++;
                    $num = 'SD-GEN-' . str_pad((string) $sdCounter, 4, '0', STR_PAD_LEFT);
                } else {
                    $smpCounter++;
                    $num = 'SMP-GEN-' . str_pad((string) $smpCounter, 4, '0', STR_PAD_LEFT);
                }
            }

            while (isset($usedNumbersMap[$num])) {
                if ($mType === 'SD') {
                    $sdCounter++;
                    $num = 'SD-GEN-' . str_pad((string) $sdCounter, 4, '0', STR_PAD_LEFT);
                } else {
                    $smpCounter++;
                    $num = 'SMP-GEN-' . str_pad((string) $smpCounter, 4, '0', STR_PAD_LEFT);
                }
            }

            $existing = Member::where('name', $st['name'])
                ->where('member_type', $mType)
                ->first();

            if ($existing) {
                $existing->update([
                    'grade' => $st['grade'],
                    'status' => 'active',
                ]);
                $updatedCount++;
            } else {
                Member::create([
                    'member_number' => $num,
                    'name' => $st['name'],
                    'email' => null,
                    'phone' => null,
                    'member_type' => $mType,
                    'grade' => $st['grade'],
                    'status' => 'active',
                    'joined_at' => now(),
                ]);
                $usedNumbersMap[$num] = true;
                $insertedCount++;
            }
        }

        if (isset($this->command)) {
            $this->command->info("Student dataset imported successfully: {$insertedCount} created, {$updatedCount} updated.");
        }
    }
}
