<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // e.g., ELEC1, MATH101
            $table->string('name'); // e.g., Electronics 1, Mathematics 101
            $table->text('description')->nullable();
            $table->integer('units')->default(3);
            $table->timestamps();
        });
        
        // Create pivot table for student-subject enrollments
        Schema::create('student_subject', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->timestamps();
            
            // Prevent duplicate enrollments
            $table->unique(['student_id', 'subject_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_subject');
        Schema::dropIfExists('subjects');
    }
};
