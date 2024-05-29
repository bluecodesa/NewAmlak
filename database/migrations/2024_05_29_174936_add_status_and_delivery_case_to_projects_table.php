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
        Schema::table('projects', function (Blueprint $table) {

            $table->text('note')->nullable();
            $table->unsignedBigInteger('project_status_id')->nullable()->after('district_id');
            $table->unsignedBigInteger('delivery_case_id')->nullable()->after('project_status_id');

            $table->foreign('project_status_id')
                  ->references('id')
                  ->on('project_statuses')
                  ->onDelete('set null');

            $table->foreign('delivery_case_id')
                  ->references('id')
                  ->on('delivery_cases')
                  ->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            //
            $table->dropForeign(['project_status_id']);
            $table->dropForeign(['delivery_case_id']);
            $table->dropColumn(['project_status_id', 'delivery_case_id']);
        });
    }
};
