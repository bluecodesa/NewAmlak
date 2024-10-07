<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('request_statuses', function (Blueprint $table) {
            $table->unsignedBigInteger('read_by')->nullable()->after('request_status_id');
        });
    }

    public function down()
    {
        Schema::table('request_statuses', function (Blueprint $table) {
            $table->dropColumn('read_by');
        });
    }
};
