<?php
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Drop empty degrees table
// okay na 
DB::statement('DROP TABLE IF EXISTS degrees');

// Rename subjects to courses_new temporarily
DB::statement('RENAME TABLE subjects TO courses_new');

// Rename courses to degrees
DB::statement('RENAME TABLE courses TO degrees');

// Rename courses_new to courses
DB::statement('RENAME TABLE courses_new TO courses');

// Rename student_subject to course_student
DB::statement('RENAME TABLE student_subject TO course_student');

// Update students table: course_id to degree_id
DB::statement('ALTER TABLE students CHANGE COLUMN course_id degree_id BIGINT UNSIGNED NULL');

echo "Tables renamed successfully!\n";
echo "- degrees table: BSIT, BSFM (programs)\n";
echo "- courses table: ELEC 1, ELEC 2 (subjects)\n";
echo "- course_student pivot: student enrollments\n";
