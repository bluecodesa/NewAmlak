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

        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->unsignedBigInteger('office_id')->nullable();
            $table->integer('broker_id')->unsigned()->nullable();
            $table->integer('owner_id')->unsigned()->nullable();
            $table->integer('developer_id')->unsigned()->nullable();
            $table->integer('advisor_id')->unsigned()->nullable();
            $table->integer('employee_id')->unsigned()->nullable();
            $table->integer('city_id')->unsigned()->nullable();
            $table->string('location')->nullable();
            $table->string('lat_long')->nullable();
            $table->text('image')->nullable();
            $table->integer('service_type_id')->unsigned()->nullable();
            $table->foreign('service_type_id')->references('id')->on('service_types')->onDelete('cascade');
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('owner_id')->references('id')->on('owners')->onDelete('cascade');
            $table->foreign('developer_id')->references('id')->on('developers')->onDelete('cascade');
            $table->foreign('advisor_id')->references('id')->on('advisors')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('broker_id')->references('id')->on('brokers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};