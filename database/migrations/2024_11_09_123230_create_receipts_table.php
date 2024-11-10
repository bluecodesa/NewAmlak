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
            $table->string('receipt_id')->unique();
            $table->foreignId('office_id')->constrained('offices')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('broker_id')->constrained('brokers')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->foreignId('owner_id')->constrained('owners')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->enum('status', ['Under review', 'accepted', 'rejected'])->default('Under review'); // Status field
            $table->string('receipt');
            $table->text('comment')->nullable();
            $table->timestamps();
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
