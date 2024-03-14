<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number_unit')->nullable();
            $table->unsignedBigInteger('office_id')->nullable();
            $table->integer('broker_id')->unsigned()->nullable();
            $table->integer('employee_id')->unsigned()->nullable();
            $table->integer('owner_id')->unsigned()->nullable();
            $table->integer('space')->nullable();
            $table->integer('rooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->boolean('show_gallery')->default(1)->nullable();
            $table->integer('price')->default(1)->nullable();
            $table->string('type')->default('rent')->nullable();
            $table->integer('property_id')->unsigned()->nullable();
            $table->string('location')->nullable();
            $table->string('lat_long')->nullable();
            $table->integer('city_id')->unsigned()->nullable();
            $table->string('instrument_number')->unique()->nullable();
            $table->integer('property_type_id')->unsigned()->nullable();
            $table->integer('property_usage_id')->unsigned()->nullable();
            $table->integer('service_type_id')->unsigned()->nullable();
            $table->foreign('service_type_id')->references('id')->on('service_types')->onDelete('cascade');
            $table->foreign('property_usage_id')->references('id')->on('property_usages')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('owner_id')->references('id')->on('owners')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->foreign('broker_id')->references('id')->on('brokers')->onDelete('cascade');
            $table->foreign('property_type_id')->references('id')->on('property_types')->onDelete('cascade');
            $table->enum('status', ['vacant', 'rented'])->default('vacant'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
