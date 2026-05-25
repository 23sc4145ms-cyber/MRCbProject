<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('students') || ! Schema::hasColumn('students', 'user_id')) {
            return;
        }

        Schema::table('students', function (Blueprint $table) {
            try {
                $table->dropForeign(['user_id']);
            } catch (\Throwable $e) {
                // The legacy foreign key may already be missing.
            }
        });

        if (! Schema::hasTable('user_accounts')) {
            return;
        }

        try {
            DB::statement(
                'ALTER TABLE students ADD CONSTRAINT students_user_id_foreign FOREIGN KEY (user_id) REFERENCES user_accounts(id) ON DELETE CASCADE'
            );
        } catch (\Throwable $e) {
            // The target foreign key already exists.
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('students') || ! Schema::hasColumn('students', 'user_id')) {
            return;
        }

        Schema::table('students', function (Blueprint $table) {
            try {
                $table->dropForeign(['user_id']);
            } catch (\Throwable $e) {
                // Ignore missing foreign keys during rollback.
            }
        });

        if (! Schema::hasTable('users')) {
            return;
        }

        try {
            DB::statement(
                'ALTER TABLE students ADD CONSTRAINT students_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE'
            );
        } catch (\Throwable $e) {
            // Ignore if the legacy foreign key cannot be recreated.
        }
    }
};
