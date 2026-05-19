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
        Schema::table('students', function (Blueprint $table) {
            // Drop the old foreign key and column
            $table->dropForeign(['degree_id']);
            $table->dropColumn('degree_id');
            
            // Add the new course_id column
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Drop the course_id foreign key and column
            $table->dropForeign(['course_id']);
            $table->dropColumn('course_id');
            
            // Restore the old degree_id column
            $table->foreignId('degree_id')->nullable()->constrained('degrees')->onDelete('cascade');
        });
    }
};
