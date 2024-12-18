<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('broker_office_service_provider', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_provider_id');
            $table->unsignedInteger('broker_id')->nullable();
            $table->unsignedBigInteger('office_id')->nullable();
            $table->timestamps();

            // Foreign Keys
            $table->foreign('service_provider_id')->references('id')->on('service_providers')->onDelete('cascade');
            $table->foreign('broker_id')->references('id')->on('brokers')->onDelete('cascade');
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('broker_office_provider_service');
    }
};
