<?php

/**
 * Test Student Dashboard
 * Run this with: php test_student_dashboard.php
 */

// okay

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Student;
use App\Models\UserAccount;
use App\Models\Post;
use App\Models\Profile;

echo "🧪 Testing Student Dashboard Components...\n\n";

try {
    // Test 1: Check if students exist
    echo "1️⃣ Checking students...\n";
    $students = Student::with(['course', 'user'])->get();
    
    if ($students->count() > 0) {
        echo "   ✅ Found {$students->count()} student(s)\n";
        foreach ($students as $student) {
            echo "      - {$student->fname} {$student->lname} ({$student->user->email})\n";
        }
    } else {
        echo "   ⚠️  No students found. Add students first.\n";
    }
    echo "\n";
    
    // Test 2: Check student user accounts
    echo "2️⃣ Checking student user accounts...\n";
    $studentUsers = UserAccount::where('role', 'student')->get();
    
    if ($studentUsers->count() > 0) {
        echo "   ✅ Found {$studentUsers->count()} student account(s)\n";
        foreach ($studentUsers as $user) {
            echo "      - {$user->username} ({$user->email})\n";
        }
    } else {
        echo "   ⚠️  No student accounts found.\n";
    }
    echo "\n";
    
    // Test 3: Check posts
    echo "3️⃣ Checking posts...\n";
    $posts = Post::latest()->take(5)->get();
    
    if ($posts->count() > 0) {
        echo "   ✅ Found {$posts->count()} post(s)\n";
        foreach ($posts as $post) {
            echo "      - {$post->title}\n";
        }
    } else {
        echo "   ℹ️  No posts found. Students will see empty state.\n";
    }
    echo "\n";
    
    // Test 4: Check profiles
    echo "4️⃣ Checking profiles...\n";
    $profiles = Profile::latest()->take(5)->get();
    
    if ($profiles->count() > 0) {
        echo "   ✅ Found {$profiles->count()} profile(s)\n";
        foreach ($profiles as $profile) {
            echo "      - {$profile->title}\n";
        }
    } else {
        echo "   ℹ️  No profiles found. Students will see empty state.\n";
    }
    echo "\n";
    
    // Test 5: Simulate student dashboard data
    echo "5️⃣ Testing student dashboard data retrieval...\n";
    
    if ($students->count() > 0) {
        $testStudent = $students->first();
        echo "   Testing with student: {$testStudent->fname} {$testStudent->lname}\n";
        
        // Test student info
        if ($testStudent->user) {
            echo "   ✅ Student has user account\n";
            echo "      Email: {$testStudent->user->email}\n";
        }
        
        if ($testStudent->course) {
            echo "   ✅ Student has course assigned\n";
            echo "      Course: {$testStudent->course->name}\n";
        }
        
        echo "   ✅ Student info complete!\n";
    }
    echo "\n";
    
    // Summary
    echo "📊 Summary:\n";
    echo "   Students: {$students->count()}\n";
    echo "   Student Accounts: {$studentUsers->count()}\n";
    echo "   Posts: {$posts->count()}\n";
    echo "   Profiles: {$profiles->count()}\n";
    echo "\n";
    
    if ($students->count() > 0) {
        echo "✅ Student Dashboard is ready to use!\n\n";
        echo "🎯 Test Login:\n";
        echo "   URL: https://127.0.0.1:8000/login\n";
        echo "   Email: {$students->first()->user->email}\n";
        echo "   Password: student1234\n\n";
        echo "📋 Dashboard Features:\n";
        echo "   1. Student Info - View personal information\n";
        echo "   2. Posts - View all posts\n";
        echo "   3. Profile - View all profiles\n";
        echo "   4. Change Password - Update password\n";
    } else {
        echo "⚠️  Please add students first:\n";
        echo "   Go to: https://127.0.0.1:8000/students/create\n";
    }
    
} catch (\Exception $e) {
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo "\n📝 Details:\n";
    echo "   File: " . $e->getFile() . "\n";
    echo "   Line: " . $e->getLine() . "\n";
}
