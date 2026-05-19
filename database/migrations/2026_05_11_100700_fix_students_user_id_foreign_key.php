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
            // Drop the old foreign key constraint
            $table->dropForeign(['user_id']);
            
            // Add the new foreign key constraint pointing to user_accounts
            $table->foreign('user_id')->references('id')->on('user_accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Drop the user_accounts foreign key
            $table->dropForeign(['user_id']);
            
            // Restore the old foreign key pointing to users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
