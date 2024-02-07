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
        Schema::create('brokers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('license_number');
            $table->string('email')->unique();
            $table->string('mobile');
            $table->string('city');
            $table->string('password');
            $table->unsignedInteger('subscription_type_id');
            $table->string('id_number');
            $table->foreign('subscription_type_id')->references('id')->on('subscription_types')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brokers');
    }
};
