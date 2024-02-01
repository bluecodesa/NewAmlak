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
        Schema::create('subscription_type_sections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subscription_type_id')->unsigned()->nullable();
            $table->integer('section_id')->unsigned()->nullable();
            $table->foreign('subscription_type_id')->references('id')->on('subscription_types')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_type_sections');
    }
};