<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('system_invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_ID')->unique();
            $table->unsignedBigInteger('office_id')->nullable();
            $table->integer('broker_id')->unsigned()->nullable();
            $table->string('subscription_name')->nullable();
            $table->double('amount', 8, 2)->nullable();
            $table->string('status')->nullable();
            $table->integer('period')->nullable();
            $table->string('period_type')->nullable();
            $table->string('subscription_type')->nullable();
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
            $table->foreign('broker_id')->references('id')->on('brokers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_invoices');
    }
};
