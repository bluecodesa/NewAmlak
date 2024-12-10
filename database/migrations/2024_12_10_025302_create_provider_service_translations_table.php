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
        Schema::create('provider_service_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_service_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['provider_service_id', 'locale']);

            $table->foreign('provider_service_id')->references('id')->on('provider_services')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_service_translations');
    }
};
