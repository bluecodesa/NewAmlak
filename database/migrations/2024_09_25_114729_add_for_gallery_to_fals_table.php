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
        Schema::table('fals', function (Blueprint $table) {
            $table->boolean('for_gallery')->default(0)->after('id'); // Add the for_gallery column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fals', function (Blueprint $table) {
            $table->dropColumn('for_gallery'); // Remove the column if rolling back
        });
    }
};
