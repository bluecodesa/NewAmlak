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
        Schema::create('advertisings', function (Blueprint $table) {
            $table->id();
            $table->string('ad_name');
            $table->enum('status', ['Published', 'Scheduled', 'Finished']);
            $table->string('client_name');
            $table->dateTime('show_start_date');
            $table->integer('ad_duration'); // In days, hours, etc.
            $table->dateTime('show_end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisings');
    }
};
