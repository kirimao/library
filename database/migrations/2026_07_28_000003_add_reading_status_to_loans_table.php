<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->enum('reading_status', ['sedang_dibaca', 'selesai_dibaca', 'belum_selesai'])
                  ->default('sedang_dibaca')
                  ->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn('reading_status');
        });
    }
};
