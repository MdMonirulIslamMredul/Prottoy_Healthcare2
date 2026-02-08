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
        Schema::create('organizational_roles', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g., "Managing Director"
            $table->string('subtitle')->nullable(); // e.g., "Central Management & Oversight"
            $table->string('icon')->nullable(); // Bootstrap icon class
            $table->integer('level')->default(1); // Hierarchy level 1-6
            $table->string('color_start')->default('#667eea'); // Gradient start color
            $table->string('color_end')->default('#764ba2'); // Gradient end color
            $table->text('responsibilities'); // JSON array of duties
            $table->text('stats')->nullable(); // JSON array of stats badges
            $table->integer('order')->default(0); // Display order
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizational_roles');
    }
};
