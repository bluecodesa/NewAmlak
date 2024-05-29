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
        Schema::create('project_status_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_status_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['project_status_id', 'locale']);

            $table->foreign('project_status_id')->references('id')->on('project_status')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_types_translations');
    }
};
