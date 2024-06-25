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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('property_id');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('employee_id');
            $table->decimal('price', 10, 2);
            $table->string('type');
            $table->unsignedBigInteger('service_type_id');
            $table->decimal('commissions_rate', 5, 2)->nullable();
            $table->string('collection_type')->nullable();
            $table->unsignedBigInteger('renter_id');
            $table->date('contract_date');
            $table->integer('contract_duration');
            $table->string('duration_unit');
            $table->string('payment_cycle');
            $table->boolean('auto_renew')->default(false);
            $table->string('status')->default('active'); // Added status column
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->foreign('owner_id')->references('id')->on('owners')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('service_type_id')->references('id')->on('service_types')->onDelete('cascade');
            $table->foreign('renter_id')->references('id')->on('renters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
