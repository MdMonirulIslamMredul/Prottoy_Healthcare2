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
            $table->foreignId('division_id')->nullable()->after('role')->constrained('divisions')->onDelete('set null');
            $table->foreignId('district_id')->nullable()->after('division_id')->constrained('districts')->onDelete('set null');
            $table->foreignId('upzila_id')->nullable()->after('district_id')->constrained('upzilas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['division_id']);
            $table->dropForeign(['district_id']);
            $table->dropForeign(['upzila_id']);
            $table->dropColumn(['division_id', 'district_id', 'upzila_id']);
        });
    }
};
