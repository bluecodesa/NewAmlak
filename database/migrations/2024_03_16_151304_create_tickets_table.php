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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('broker_id');
            $table->unsignedBigInteger('office_id');
            $table->string('subject');
            $table->text('content');
            $table->string('image')->nullable();
            $table->text('admin_response')->nullable();
            $table->enum('status', ['Waiting for technical support', 'Waiting for the customer'])->default('Waiting for technical support');
            $table->unsignedBigInteger('ticket_type_id')->nullable();
            $table->foreign('broker_id')->references('id')->on('brokers')->onDelete('cascade');
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
            $table->foreign('ticket_type_id')->references('id')->on('ticket_types')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
