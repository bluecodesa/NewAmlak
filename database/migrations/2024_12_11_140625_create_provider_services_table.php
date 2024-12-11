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
        Schema::create('provider_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_service_type_id');
            $table->decimal('price', 10, 2);
            $table->text('description');
            $table->timestamps();

            $table->foreign('provider_service_type_id')
                ->references('id')
                ->on('provider_service_types')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_services');
    }
};
