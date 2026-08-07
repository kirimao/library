<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (!Schema::hasColumn('books', 'price')) {
                $table->decimal('price', 12, 2)->nullable()->after('publisher');
            }
            if (!Schema::hasColumn('books', 'cover_type')) {
                $table->string('cover_type', 50)->nullable()->after('price');
            }
        });

        Schema::table('loans', function (Blueprint $table) {
            $table->datetime('loan_date')->change();
            $table->datetime('return_date')->nullable()->change();
            if (!Schema::hasColumn('loans', 'reported_lost_by')) {
                $table->foreignId('reported_lost_by')->nullable()->constrained('users')->nullOnDelete()->after('fine_amount');
            }
            if (!Schema::hasColumn('loans', 'reported_lost_at')) {
                $table->datetime('reported_lost_at')->nullable()->after('reported_lost_by');
            }
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (Schema::hasColumn('books', 'price')) {
                $table->dropColumn('price');
            }
            if (Schema::hasColumn('books', 'cover_type')) {
                $table->dropColumn('cover_type');
            }
        });

        Schema::table('loans', function (Blueprint $table) {
            if (Schema::hasColumn('loans', 'reported_lost_by')) {
                $table->dropForeign(['reported_lost_by']);
                $table->dropColumn('reported_lost_by');
            }
            if (Schema::hasColumn('loans', 'reported_lost_at')) {
                $table->dropColumn('reported_lost_at');
            }
        });
    }
};
