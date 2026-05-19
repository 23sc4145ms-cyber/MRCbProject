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
        // Check if student_id column exists and drop it
        if (Schema::hasColumn('students', 'student_id')) {
            Schema::table('students', function (Blueprint $table) {
                $table->dropColumn('student_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add it back if needed
        Schema::table('students', function (Blueprint $table) {
            $table->string('student_id')->nullable()->after('id');
        });
    }
};
