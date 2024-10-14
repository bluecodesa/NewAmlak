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
        Schema::create('whatsapp_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('notification_setting_id')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->text('content')->nullable();
            $table->string('type')->nullable();
            $table->foreign('notification_setting_id')->references('id')->on('notification_settings')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_templates');
    }
};
