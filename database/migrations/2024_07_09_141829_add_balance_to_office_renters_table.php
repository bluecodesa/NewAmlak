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
        Schema::table('office_renters', function (Blueprint $table) {
            //
            $table->decimal('financial_Due', 10, 2)->default(0)->after('renter_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('renters', function (Blueprint $table) {
            //
        });
    }
};
