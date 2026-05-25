<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Drop the incorrect foreign key constraint
        try {
            DB::statement('ALTER TABLE course_students DROP FOREIGN KEY course_students_course_id_foreign');
        } catch (\Exception $e) {
            // Foreign key might not exist or have different name
        }
        
        // Add the correct foreign key constraint that references courses table
        DB::statement('ALTER TABLE course_students ADD CONSTRAINT course_students_course_id_foreign FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE');
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Drop the correct foreign key
        try {
            DB::statement('ALTER TABLE course_students DROP FOREIGN KEY course_students_course_id_foreign');
        } catch (\Exception $e) {
            // Ignore
        }
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
