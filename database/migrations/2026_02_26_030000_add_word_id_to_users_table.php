<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'word_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('word_id')->nullable()->after('union_id');
                $table->foreign('word_id')->references('id')->on('words')->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'word_id')) {
            Schema::table('users', function (Blueprint $table) {
                try {
                    $table->dropForeign(['word_id']);
                } catch (\Throwable $e) {
                }
                $table->dropColumn('word_id');
            });
        }
    }
};
