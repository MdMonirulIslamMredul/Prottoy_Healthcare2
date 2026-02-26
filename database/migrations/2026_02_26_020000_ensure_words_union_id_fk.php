<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('words') || !Schema::hasTable('unions')) {
            return;
        }

        // Ensure union_id column exists
        if (!Schema::hasColumn('words', 'union_id')) {
            Schema::table('words', function ($table) {
                $table->unsignedBigInteger('union_id')->nullable();
            });
        }

        // Check if foreign key already exists
        $fk = DB::selectOne("SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'words' AND COLUMN_NAME = 'union_id' AND REFERENCED_TABLE_NAME = 'unions' AND REFERENCED_COLUMN_NAME = 'id'");
        if ($fk) {
            return; // FK already present
        }

        // Get unions.id column type
        $unionIdCol = DB::selectOne("SELECT COLUMN_TYPE, COLUMN_KEY FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'unions' AND COLUMN_NAME = 'id'");
        if (!$unionIdCol) {
            return; // can't determine
        }

        $type = $unionIdCol->COLUMN_TYPE; // e.g., bigint(20) unsigned or int(11)

        // Build ALTER statement to change words.union_id to match unions.id
        try {
            DB::statement("ALTER TABLE `words` CHANGE `union_id` `union_id` $type NULL");
        } catch (\Throwable $e) {
            // best-effort: if this fails (no permission or SQL dialect), continue to try adding FK
        }

        // Add foreign key constraint
        try {
            DB::statement("ALTER TABLE `words` ADD CONSTRAINT `words_union_id_foreign` FOREIGN KEY (`union_id`) REFERENCES `unions` (`id`) ON DELETE CASCADE");
        } catch (\Throwable $e) {
            // ignore failures
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('words')) {
            return;
        }

        // Drop foreign key if exists
        try {
            DB::statement("ALTER TABLE `words` DROP FOREIGN KEY `words_union_id_foreign`");
        } catch (\Throwable $e) {
            // ignore
        }
    }
};
