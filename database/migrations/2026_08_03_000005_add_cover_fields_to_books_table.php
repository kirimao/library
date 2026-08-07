<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (!Schema::hasColumn('books', 'cover_image')) {
                $table->string('cover_image')->nullable()->after('shelf_location');
            }
            if (!Schema::hasColumn('books', 'cover_thumbnail')) {
                $table->string('cover_thumbnail')->nullable()->after('cover_image');
            }
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $columnsToDrop = [];
            if (Schema::hasColumn('books', 'cover_thumbnail')) {
                $columnsToDrop[] = 'cover_thumbnail';
            }
            if (Schema::hasColumn('books', 'cover_image')) {
                $columnsToDrop[] = 'cover_image';
            }
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
