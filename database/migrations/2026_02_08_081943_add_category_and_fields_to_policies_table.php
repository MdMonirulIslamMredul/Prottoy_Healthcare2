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
        Schema::table('policies', function (Blueprint $table) {
            $table->string('category')->nullable()->after('title'); // privacy, terms, memorandum, etc.
            $table->text('description')->nullable()->after('category');
            $table->string('icon')->nullable()->after('description'); // Bootstrap icon class
            $table->string('color')->default('#667eea')->after('icon'); // Border/accent color
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('policies', function (Blueprint $table) {
            $table->dropColumn(['category', 'description', 'icon', 'color']);
        });
    }
};
