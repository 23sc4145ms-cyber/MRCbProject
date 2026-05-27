<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('courses')) {
            Schema::table('courses', function (Blueprint $table) {
                // Check if columns already exist before adding
                if (!Schema::hasColumn('courses', 'code')) {
                    $table->string('code')->nullable()->unique()->after('id');
                }
                if (!Schema::hasColumn('courses', 'units')) {
                    $table->integer('units')->default(3)->nullable()->after('description');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('courses')) {
            Schema::table('courses', function (Blueprint $table) {
                if (Schema::hasColumn('courses', 'code')) {
                    $table->dropUnique(['code']);
                    $table->dropColumn('code');
                }
                if (Schema::hasColumn('courses', 'units')) {
                    $table->dropColumn('units');
                }
            });
        }
    }
};
