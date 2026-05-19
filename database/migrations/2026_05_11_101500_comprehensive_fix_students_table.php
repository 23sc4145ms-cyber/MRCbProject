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
        // Use raw SQL to avoid issues with existing constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Drop all existing foreign keys on students table
        try {
            DB::statement('ALTER TABLE students DROP FOREIGN KEY students_user_id_foreign');
        } catch (\Exception $e) {
            // Foreign key might not exist
        }
        
        try {
            DB::statement('ALTER TABLE students DROP FOREIGN KEY students_degree_id_foreign');
        } catch (\Exception $e) {
            // Foreign key might not exist
        }
        
        try {
            DB::statement('ALTER TABLE students DROP FOREIGN KEY students_course_id_foreign');
        } catch (\Exception $e) {
            // Foreign key might not exist
        }
        
        // Check if degree_id column exists and rename it to course_id
        $columns = Schema::getColumnListing('students');
        
        if (in_array('degree_id', $columns) && !in_array('course_id', $columns)) {
            DB::statement('ALTER TABLE students CHANGE COLUMN degree_id course_id BIGINT UNSIGNED NULL');
        } elseif (!in_array('course_id', $columns)) {
            // Add course_id if it doesn't exist
            Schema::table('students', function (Blueprint $table) {
                $table->foreignId('course_id')->nullable()->after('contact');
            });
        }
        
        // Add the correct foreign key constraints
        DB::statement('ALTER TABLE students ADD CONSTRAINT students_user_id_foreign FOREIGN KEY (user_id) REFERENCES user_accounts(id) ON DELETE CASCADE');
        DB::statement('ALTER TABLE students ADD CONSTRAINT students_course_id_foreign FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE');
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Drop the new foreign keys
        try {
            DB::statement('ALTER TABLE students DROP FOREIGN KEY students_user_id_foreign');
        } catch (\Exception $e) {
            // Ignore
        }
        
        try {
            DB::statement('ALTER TABLE students DROP FOREIGN KEY students_course_id_foreign');
        } catch (\Exception $e) {
            // Ignore
        }
        
        // Restore old foreign keys
        DB::statement('ALTER TABLE students ADD CONSTRAINT students_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
        
        // Rename course_id back to degree_id
        $columns = Schema::getColumnListing('students');
        if (in_array('course_id', $columns)) {
            DB::statement('ALTER TABLE students CHANGE COLUMN course_id degree_id BIGINT UNSIGNED NULL');
            DB::statement('ALTER TABLE students ADD CONSTRAINT students_degree_id_foreign FOREIGN KEY (degree_id) REFERENCES degrees(id) ON DELETE CASCADE');
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
