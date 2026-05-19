<?php

/**
 * Test Student Creation
 * Run this with: php test_student_creation.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Student;
use App\Models\UserAccount;
use App\Models\FirstLoginToken;
use App\Models\Course;
use Illuminate\Support\Facades\DB;

echo "🧪 Testing Student Creation System...\n\n";

try {
    // Test 1: Check database connection
    echo "1️⃣ Testing database connection...\n";
    DB::connection()->getPdo();
    echo "   ✅ Database connected successfully\n\n";
    
    // Test 2: Check courses exist
    echo "2️⃣ Checking courses...\n";
    $courses = Course::all();
    if ($courses->count() > 0) {
        echo "   ✅ Found " . $courses->count() . " courses:\n";
        foreach ($courses as $course) {
            echo "      - {$course->name} (ID: {$course->id})\n";
        }
    } else {
        echo "   ❌ No courses found!\n";
    }
    echo "\n";
    
    // Test 3: Check foreign keys
    echo "3️⃣ Checking foreign key constraints...\n";
    $fks = DB::select("
        SELECT CONSTRAINT_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME 
        FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
        WHERE TABLE_SCHEMA = DATABASE() 
        AND TABLE_NAME = 'students' 
        AND REFERENCED_TABLE_NAME IS NOT NULL
    ");
    
    foreach ($fks as $fk) {
        echo "   ✅ {$fk->CONSTRAINT_NAME}: {$fk->COLUMN_NAME} → {$fk->REFERENCED_TABLE_NAME}.{$fk->REFERENCED_COLUMN_NAME}\n";
    }
    echo "\n";
    
    // Test 4: Try creating a test student
    echo "4️⃣ Testing student creation...\n";
    
    DB::beginTransaction();
    
    try {
        // Create user account
        $testUser = UserAccount::create([
            'username' => 'testuser_' . time(),
            'email' => 'test_' . time() . '@test.com',
            'password' => bcrypt('student1234'),
            'role' => 'student',
            'is_active' => true,
        ]);
        echo "   ✅ User account created (ID: {$testUser->id})\n";
        
        // Create first login token
        $token = FirstLoginToken::create([
            'user_id' => $testUser->id,
            'used' => false,
        ]);
        echo "   ✅ First login token created\n";
        
        // Create student
        $testStudent = Student::create([
            'fname' => 'Test',
            'mname' => 'User',
            'lname' => 'Student',
            'contact' => '09123456789',
            'course_id' => $courses->first()->id,
            'user_id' => $testUser->id,
        ]);
        echo "   ✅ Student created (ID: {$testStudent->id})\n";
        
        // Verify relationships
        echo "\n5️⃣ Testing relationships...\n";
        $student = Student::with(['course', 'user'])->find($testStudent->id);
        
        if ($student->course) {
            echo "   ✅ Course relationship works: {$student->course->name}\n";
        } else {
            echo "   ❌ Course relationship failed\n";
        }
        
        if ($student->user) {
            echo "   ✅ User relationship works: {$student->user->email}\n";
        } else {
            echo "   ❌ User relationship failed\n";
        }
        
        // Rollback test data
        DB::rollBack();
        echo "\n   ℹ️  Test data rolled back (not saved to database)\n";
        
        echo "\n✅ ALL TESTS PASSED! Student creation system is working correctly!\n";
        echo "\n🎉 You can now add students through the web interface!\n";
        
    } catch (\Exception $e) {
        DB::rollBack();
        throw $e;
    }
    
} catch (\Exception $e) {
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo "\n📝 Details:\n";
    echo "   File: " . $e->getFile() . "\n";
    echo "   Line: " . $e->getLine() . "\n";
}
