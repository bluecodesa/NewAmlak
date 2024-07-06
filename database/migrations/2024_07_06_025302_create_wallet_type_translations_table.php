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
        Schema::create('wallet_type_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wallet_type_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['wallet_type_id', 'locale']);

            $table->foreign('wallet_type_id')->references('id')->on('wallet_types')->onDelete('cascade');

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
