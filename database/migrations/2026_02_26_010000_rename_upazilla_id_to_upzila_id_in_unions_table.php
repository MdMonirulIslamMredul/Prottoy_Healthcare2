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
        if (Schema::hasTable('unions') && Schema::hasColumn('unions', 'upazilla_id') && !Schema::hasColumn('unions', 'upzila_id')) {
            // Try to get exact column definition and rename using raw SQL to avoid requiring doctrine/dbal
            $col = DB::selectOne("SELECT COLUMN_TYPE, IS_NULLABLE, COLUMN_DEFAULT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'unions' AND COLUMN_NAME = 'upazilla_id'");
            if ($col) {
                $type = $col->COLUMN_TYPE;
                $nullable = ($col->IS_NULLABLE === 'YES') ? 'NULL' : 'NOT NULL';
                $default = ($col->COLUMN_DEFAULT !== null) ? "DEFAULT '" . addslashes($col->COLUMN_DEFAULT) . "'" : '';
                DB::statement("ALTER TABLE `unions` CHANGE `upazilla_id` `upzila_id` $type $nullable $default");
            } else {
                try {
                    Schema::table('unions', function (Blueprint $table) {
                        $table->renameColumn('upazilla_id', 'upzila_id');
                    });
                } catch (\Throwable $e) {
                    // best-effort; if renameColumn fails and INFORMATION_SCHEMA didn't return a row, give up
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('unions') && Schema::hasColumn('unions', 'upzila_id') && !Schema::hasColumn('unions', 'upazilla_id')) {
            $col = DB::selectOne("SELECT COLUMN_TYPE, IS_NULLABLE, COLUMN_DEFAULT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'unions' AND COLUMN_NAME = 'upzila_id'");
            if ($col) {
                $type = $col->COLUMN_TYPE;
                $nullable = ($col->IS_NULLABLE === 'YES') ? 'NULL' : 'NOT NULL';
                $default = ($col->COLUMN_DEFAULT !== null) ? "DEFAULT '" . addslashes($col->COLUMN_DEFAULT) . "'" : '';
                DB::statement("ALTER TABLE `unions` CHANGE `upzila_id` `upazilla_id` $type $nullable $default");
            } else {
                try {
                    Schema::table('unions', function (Blueprint $table) {
                        $table->renameColumn('upzila_id', 'upazilla_id');
                    });
                } catch (\Throwable $e) {
                    // ignore
                }
            }
        }
    }
};
