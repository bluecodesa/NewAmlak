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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');  // Bank Name
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('account_number');  // Account Number
            $table->string('international_account_number')->nullable();  // International Account Number
            $table->bigInteger('id_number')->nullable();  // ID Number with 9 characters
            $table->string('image')->nullable();  // Path to the Image file
            $table->tinyInteger('status')->default(0); // Status with default value of 0
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
