<?php

/**
 * Quick Fix Script for Students Table
 * Run this with: php fix_students_table.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "🔧 Starting Students Table Fix...\n\n";

try {
    // Disable foreign key checks
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    echo "✓ Disabled foreign key checks\n";
    
    // Drop existing foreign keys
    echo "\n📋 Dropping old foreign keys...\n";
    
    try {
        DB::statement('ALTER TABLE students DROP FOREIGN KEY students_user_id_foreign');
        echo "✓ Dropped students_user_id_foreign\n";
    } catch (\Exception $e) {
        echo "⚠ students_user_id_foreign not found (skipping)\n";
    }
    
    try {
        DB::statement('ALTER TABLE students DROP FOREIGN KEY students_degree_id_foreign');
        echo "✓ Dropped students_degree_id_foreign\n";
    } catch (\Exception $e) {
        echo "⚠ students_degree_id_foreign not found (skipping)\n";
    }
    
    try {
        DB::statement('ALTER TABLE students DROP FOREIGN KEY students_course_id_foreign');
        echo "✓ Dropped students_course_id_foreign\n";
    } catch (\Exception $e) {
        echo "⚠ students_course_id_foreign not found (skipping)\n";
    }
    
    // Check and rename degree_id to course_id
    echo "\n📋 Checking columns...\n";
    $columns = Schema::getColumnListing('students');
    
    if (in_array('degree_id', $columns) && !in_array('course_id', $columns)) {
        DB::statement('ALTER TABLE students CHANGE COLUMN degree_id course_id BIGINT UNSIGNED NULL');
        echo "✓ Renamed degree_id to course_id\n";
    } elseif (!in_array('course_id', $columns)) {
        DB::statement('ALTER TABLE students ADD COLUMN course_id BIGINT UNSIGNED NULL AFTER contact');
        echo "✓ Added course_id column\n";
    } else {
        echo "✓ course_id column already exists\n";
    }
    
    // Add new foreign keys
    echo "\n📋 Adding new foreign keys...\n";
    
    DB::statement('ALTER TABLE students ADD CONSTRAINT students_user_id_foreign FOREIGN KEY (user_id) REFERENCES user_accounts(id) ON DELETE CASCADE');
    echo "✓ Added students_user_id_foreign → user_accounts\n";
    
    DB::statement('ALTER TABLE students ADD CONSTRAINT students_course_id_foreign FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE');
    echo "✓ Added students_course_id_foreign → courses\n";
    
    // Re-enable foreign key checks
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    echo "\n✓ Re-enabled foreign key checks\n";
    
    echo "\n✅ SUCCESS! Students table has been fixed!\n";
    echo "\n📊 Current students table structure:\n";
    
    $result = DB::select('SHOW CREATE TABLE students');
    echo $result[0]->{'Create Table'} . "\n\n";
    
    echo "🎉 You can now add students successfully!\n";
    
} catch (\Exception $e) {
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo "\n📝 Stack trace:\n" . $e->getTraceAsString() . "\n";
    
    // Try to re-enable foreign key checks
    try {
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    } catch (\Exception $e2) {
        // Ignore
    }
}
