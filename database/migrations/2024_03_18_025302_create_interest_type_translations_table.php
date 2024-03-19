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
        Schema::create('interest_type_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('interest_type_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['interest_type_id', 'locale']);

            $table->foreign('interest_type_id')->references('id')->on('interest_types')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interest_type_translations');
    }
};
