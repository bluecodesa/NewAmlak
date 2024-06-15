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
        Schema::create('office_renters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('office_id');
            $table->unsignedBigInteger('renter_id');
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
            $table->foreign('renter_id')->references('id')->on('renters')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_renters');
    }
};
