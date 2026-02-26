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
        if (!Schema::hasColumn('users', 'union_id')) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'union_id')) {
                    $table->unsignedBigInteger('union_id')->nullable()->after('upzila_id');
                    $table->foreign('union_id')->references('id')->on('unions')->onDelete('set null');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'union_id')) {
            Schema::table('users', function (Blueprint $table) {
                try {
                    $table->dropForeign(['union_id']);
                } catch (\Exception $e) {
                    // ignore if foreign key does not exist
                }
                $table->dropColumn('union_id');
            });
        }
    }
};
