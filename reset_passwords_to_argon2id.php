<?php

/**
 * Reset all passwords to use Argon2id hashing
 * Run this with: php reset_passwords_to_argon2id.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\UserAccount;
use Illuminate\Support\Facades\Hash;

echo "🔐 Resetting all passwords to Argon2id...\n\n";

try {
    $users = UserAccount::all();
    
    if ($users->count() === 0) {
        echo "⚠️  No user accounts found.\n";
        echo "   Run: php artisan db:seed --class=UserSeeder\n";
        exit;
    }
    
    echo "Found {$users->count()} user account(s)\n\n";
    
    foreach ($users as $user) {
        $defaultPassword = match($user->role) {
            'admin' => 'admin1234',
            'teacher' => 'teacher1234',
            'student' => 'student1234',
            default => 'password1234'
        };
        
        echo "Updating: {$user->email} ({$user->role})\n";
        echo "  Old password hash: " . substr($user->password, 0, 20) . "...\n";
        
        $user->password = Hash::make($defaultPassword);
        $user->save();
        
        echo "  New password hash: " . substr($user->password, 0, 20) . "...\n";
        echo "  Default password: {$defaultPassword}\n";
        echo "  ✅ Updated!\n\n";
    }
    
    echo "✅ All passwords have been reset to Argon2id!\n\n";
    echo "📋 Default Passwords:\n";
    echo "   Admin: admin1234\n";
    echo "   Teacher: teacher1234\n";
    echo "   Student: student1234\n\n";
    echo "🎉 You can now login with these passwords!\n";
    
} catch (\Exception $e) {
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo "\n📝 Stack trace:\n" . $e->getTraceAsString() . "\n";
}
