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
        Schema::create('subscription_type_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subscription_type_id')->unsigned()->nullable();
            $table->string('locale')->index();
            $table->string('name')->nullable();
            $table->unique(['subscription_type_id', 'locale'], 'sub_type_trans_unique');
            $table->foreign('subscription_type_id')->references('id')->on('subscription_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_type_translations');
    }
};