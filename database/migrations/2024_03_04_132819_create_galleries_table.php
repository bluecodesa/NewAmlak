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
        Schema::create('galleries', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('office_id')->nullable();
            $table->integer('broker_id')->unsigned()->nullable();
            $table->string('gallery_cover')->nullable();
            $table->enum('gallery_status', ['1', '0'])->default('1');            $table->string('gallery_name');
            $table->foreign('broker_id')->references('id')->on('brokers')->onDelete('cascade');
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
