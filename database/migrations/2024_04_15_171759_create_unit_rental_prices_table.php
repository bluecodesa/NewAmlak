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
        Schema::create('unit_rental_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('daily')->nullable();
            $table->integer('monthly')->nullable();
            $table->integer('quarterly')->nullable();
            $table->integer('midterm')->nullable();
            $table->integer('yearly')->nullable();
            $table->integer('unit_id')->unsigned()->nullable();
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_rental_prices');
    }
};
