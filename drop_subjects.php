<?php
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

DB::statement('DROP TABLE IF EXISTS subjects');
DB::statement('DELETE FROM migrations WHERE migration LIKE "%create_subjects_table%"');

echo "Subjects table dropped successfully!\n";
