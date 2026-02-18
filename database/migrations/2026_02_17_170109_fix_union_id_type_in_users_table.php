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
        Schema::table('users', function (Blueprint $table) {
            // Drop the existing union_id column
            $table->dropColumn('union_id');
        });

        Schema::table('users', function (Blueprint $table) {
            // Recreate with correct type matching unions table id (int, not unsigned)
            $table->integer('union_id')->nullable()->after('upzila_id');
            $table->foreign('union_id')->references('id')->on('unions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['union_id']);
            $table->dropColumn('union_id');
        });

        Schema::table('users', function (Blueprint $table) {
            // Restore original bigint type
            $table->unsignedBigInteger('union_id')->nullable()->after('upzila_id');
        });
    }
};
