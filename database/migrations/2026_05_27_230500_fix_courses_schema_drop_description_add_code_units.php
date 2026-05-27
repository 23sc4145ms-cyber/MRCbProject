<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ensure `courses` has: id, code, name, units (+timestamps)
     * and remove legacy `description` column if present.
     */
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'code')) {
                $table->string('code')->after('id');
            }

            if (!Schema::hasColumn('courses', 'units')) {
                $table->unsignedTinyInteger('units')->default(3)->after('name');
            }

            if (Schema::hasColumn('courses', 'description')) {
                $table->dropColumn('description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            // Restore legacy column (nullable) if rolling back.
            if (!Schema::hasColumn('courses', 'description')) {
                $table->string('description')->nullable()->after('name');
            }

            if (Schema::hasColumn('courses', 'units')) {
                $table->dropColumn('units');
            }

            if (Schema::hasColumn('courses', 'code')) {
                $table->dropColumn('code');
            }
        });
    }
};

