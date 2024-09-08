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
        Schema::create('fallicenseUsers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('fal_id');
            $table->string('ad_license_number');
            $table->date('ad_license_expiry');
            $table->enum('ad_license_status', ['valid', 'invalid']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('fal_id')->references('id')->on('fals')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fallicense_users');
    }
};
