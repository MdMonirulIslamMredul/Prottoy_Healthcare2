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
            // Track which upazila supervisor created which PHO
            $table->unsignedBigInteger('upazila_supervisor_id')->nullable()->after('upzila_id');
            $table->foreign('upazila_supervisor_id')->references('id')->on('users')->onDelete('set null');

            // Track which PHO created which customer
            $table->unsignedBigInteger('pho_id')->nullable()->after('upazila_supervisor_id');
            $table->foreign('pho_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['upazila_supervisor_id']);
            $table->dropColumn('upazila_supervisor_id');

            $table->dropForeign(['pho_id']);
            $table->dropColumn('pho_id');
        });
    }
};
