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
        if (!Schema::hasTable('words')) {
            Schema::create('words', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('union_id');
                $table->string('name');
                $table->string('bn_name')->nullable();
                $table->timestamps();

                $table->foreign('union_id')
                    ->references('id')
                    ->on('unions')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('words')) {
            Schema::table('words', function (Blueprint $table) {
                try {
                    $table->dropForeign(['union_id']);
                } catch (\Exception $e) {
                    // ignore if foreign key does not exist
                }
            });
            Schema::dropIfExists('words');
        }
    }
};
