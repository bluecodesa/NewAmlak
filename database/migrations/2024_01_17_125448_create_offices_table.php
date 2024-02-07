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
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('CRN')->nullable();
            $table->string('company_name');
            $table->string('city');
            $table->string('status');
            $table->tinyInteger('is_deleted')->default(0);
            $table->tinyInteger('from_office')->default(0);
            $table->string('presenter_name');
            $table->string('presenter_number');
            $table->string('company_logo');
            $table->string('presenter_email');
            $table->tinyInteger('display')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offices');
    }
};
