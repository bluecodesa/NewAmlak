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
        Schema::create('owner_office_broker', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('office_id');
            $table->unsignedBigInteger('broker_id');
            $table->decimal('balance', 15, 2)->default(0);
            $table->timestamps();
            $table->foreign('owner_id')->references('id')->on('owners')->onDelete('cascade');
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
            $table->foreign('broker_id')->references('id')->on('brokers')->onDelete('cascade');
            $table->unique(['owner_id', 'office_id', 'broker_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owner_office_broker');
    }
};
