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
        Schema::create('delivery_case_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delivery_case_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['delivery_case_id', 'locale']);

            $table->foreign('delivery_case_id')->references('id')->on('delivery_cases')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_types_translations');
    }
};
