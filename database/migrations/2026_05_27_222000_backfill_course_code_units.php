<?php

use App\Models\Course;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ensure columns exist (for production DBs that missed earlier migrations)
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'code')) {
                $table->string('code')->nullable()->after('id');
            }
            if (!Schema::hasColumn('courses', 'units')) {
                $table->unsignedTinyInteger('units')->nullable()->after('description');
            }
        });

        // Backfill existing rows so UI won't show "-"
        // - code: fallback to "COURSE-{id}" (unique, stable)
        // - units: fallback to 3
        if (Schema::hasColumn('courses', 'code') && Schema::hasColumn('courses', 'units')) {
            Course::query()
                ->whereNull('code')
                ->orWhere('code', '')
                ->orderBy('id')
                ->chunkById(200, function ($courses) {
                    /** @var \App\Models\Course $course */
                    foreach ($courses as $course) {
                        $updates = [];
                        if (empty($course->code)) {
                            $updates['code'] = 'COURSE-' . $course->id;
                        }
                        if ($course->units === null) {
                            $updates['units'] = 3;
                        }
                        if ($updates) {
                            $course->forceFill($updates)->save();
                        }
                    }
                });

            Course::query()
                ->whereNull('units')
                ->orderBy('id')
                ->chunkById(200, function ($courses) {
                    foreach ($courses as $course) {
                        $course->forceFill(['units' => 3])->save();
                    }
                });
        }

        // Make columns required going forward (after backfill)
        // NOTE: Avoid $table->change() here to keep migrations working
        // on environments without doctrine/dbal (e.g. Render/Railway).
    }

    public function down(): void
    {
        // Non-destructive down migration (no-op).
    }
};

