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
        Schema::table('subscription_types', function (Blueprint $table) {
            //
            $table->enum('discount_type', ['fixed', 'incentive'])->default('fixed');
            $table->decimal('fixed_discount', 8, 2)->nullable();
            $table->integer('ads_count')->nullable();
            $table->decimal('ads_discount', 8, 2)->nullable();
            $table->integer('views_count')->nullable();
            $table->decimal('views_discount', 8, 2)->nullable();
  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_types', function (Blueprint $table) {
            //
        });
    }
};