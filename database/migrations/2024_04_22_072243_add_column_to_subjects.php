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
        Schema::table('subjects', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('chairperson_id')->nullable();

            $table->foreign('chairperson_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            //
            // Drop the foreign key constraint
            $table->dropForeign(['chairperson_id']);

            // Drop the chairperson_id column
            $table->dropColumn('chairperson_id');
        });
    }
};
