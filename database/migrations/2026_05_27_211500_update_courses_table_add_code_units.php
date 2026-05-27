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
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'code')) {
                $table->string('code')->nullable()->after('id');
            }

            if (!Schema::hasColumn('courses', 'units')) {
                $table->unsignedTinyInteger('units')->nullable()->after('description');
            }
        });
        // NOTE: Avoid $table->change() here to keep migrations working
        // on environments without doctrine/dbal (e.g. Render/Railway).
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (Schema::hasColumn('courses', 'units')) {
                $table->dropColumn('units');
            }
            if (Schema::hasColumn('courses', 'code')) {
                $table->dropColumn('code');
            }
        });
    }
};

