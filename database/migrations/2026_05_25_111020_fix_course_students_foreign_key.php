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
        $driver = DB::connection()->getDriverName();
        
        // Disable foreign key checks (MySQL only)
        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        } elseif ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
        }
        
        // Drop the incorrect foreign key constraint
        try {
            DB::statement('ALTER TABLE course_students DROP FOREIGN KEY course_students_course_id_foreign');
        } catch (\Exception $e) {
            // Foreign key might not exist or have different name
        }
        
        // Add the correct foreign key constraint that references courses table
        try {
            DB::statement('ALTER TABLE course_students ADD CONSTRAINT course_students_course_id_foreign FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE');
        } catch (\Exception $e) {
            // Constraint might already exist
        }
        
        // Re-enable foreign key checks
        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } elseif ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::connection()->getDriverName();
        
        // Disable foreign key checks
        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        } elseif ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
        }
        
        // Drop the correct foreign key
        try {
            DB::statement('ALTER TABLE course_students DROP FOREIGN KEY course_students_course_id_foreign');
        } catch (\Exception $e) {
            // Ignore
        }
        
        // Re-enable foreign key checks
        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } elseif ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
        }
    }
};
