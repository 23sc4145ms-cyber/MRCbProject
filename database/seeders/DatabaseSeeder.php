<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Degree;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default degrees
        Degree::create(['Degree' => 'BSIT']);
        Degree::create(['Degree' => 'BSCS']);
        Degree::create(['Degree' => 'BTLED']);
        Degree::create(['Degree' => 'BSIS']);

        // Call UserSeeder
        $this->call(UserSeeder::class);
        
        // Call CompleteDataSeeder to populate users and course_students tables
        $this->call(CompleteDataSeeder::class);
    }
}
