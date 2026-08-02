<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // For SQLite (used in this project), we need to recreate or use a workaround
        // SQLite doesn't support ALTER COLUMN for enum changes, so we use a string check
        // The loans table status column is already a string, so we just ensure
        // 'on_site' is a valid value by documenting it. SQLite doesn't enforce enums.
        // No schema change needed for SQLite — the status field accepts any string.
    }

    public function down(): void
    {
        // Nothing to reverse for SQLite
    }
};
