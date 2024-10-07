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
        Schema::table('unit_features', function (Blueprint $table) {
            //
            $table->unsignedInteger('property_id')->nullable()->after('unit_id');

            $table->foreign('property_id')
                  ->references('id')->on('properties')
                  ->onDelete('cascade')
                  ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unit_features', function (Blueprint $table) {
            //
        });
    }
};
