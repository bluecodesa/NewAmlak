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
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_number')->unique();
            $table->timestamp('release_date');
            $table->date('payment_date');
            $table->unsignedBigInteger('office_id');
            $table->unsignedBigInteger('contract_id');
            $table->unsignedInteger('project_id')->nullable();
            $table->unsignedInteger('property_id')->nullable();
            $table->unsignedInteger('unit_id')->nullable();
            $table->unsignedBigInteger('renter_id')->nullable();
            $table->string('payment_method');
            $table->string('type');
            $table->text('notes')->nullable();
            $table->decimal('total_price', 15, 2);
            $table->string('mobile')->nullable();
            $table->unsignedBigInteger('reference_number')->nullable();
            $table->string('transaction_number')->nullable();

            $table->timestamps();

            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('set null');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('set null');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('set null');
            $table->foreign('renter_id')->references('id')->on('renters')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
