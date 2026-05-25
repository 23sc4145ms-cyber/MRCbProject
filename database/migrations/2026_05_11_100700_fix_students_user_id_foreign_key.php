<?php

use Illuminate\Database\Migrations\Migration;
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

        $this->dropForeignKeyIfExists('students', 'students_user_id_foreign');

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

        $this->dropForeignKeyIfExists('students', 'students_user_id_foreign');

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

    private function dropForeignKeyIfExists(string $table, string $foreignKey): void
    {
        $databaseName = DB::getDatabaseName();

        $constraintExists = DB::table('information_schema.TABLE_CONSTRAINTS')
            ->where('CONSTRAINT_SCHEMA', $databaseName)
            ->where('TABLE_NAME', $table)
            ->where('CONSTRAINT_NAME', $foreignKey)
            ->where('CONSTRAINT_TYPE', 'FOREIGN KEY')
            ->exists();

        if (! $constraintExists) {
            return;
        }

        DB::statement("ALTER TABLE `{$table}` DROP FOREIGN KEY `{$foreignKey}`");
    }
};
