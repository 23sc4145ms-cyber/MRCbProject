<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Delete all posts
\App\Models\Post::truncate();
echo "✅ All posts deleted\n";

// Delete all profiles
\App\Models\Profile::truncate();
echo "✅ All profiles deleted\n";

echo "\n🎉 Posts and Profiles tables are now empty!\n";
