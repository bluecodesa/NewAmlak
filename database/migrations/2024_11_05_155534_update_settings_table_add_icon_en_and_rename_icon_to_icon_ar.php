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
        Schema::table('settings', function (Blueprint $table) {
            //
            $table->string('icon_en', 191)->nullable()->after('icon');

            $table->renameColumn('icon', 'icon_ar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            //
            $table->dropColumn('icon_en');

            // Rename `icon_ar` back to `icon`
            $table->renameColumn('icon_ar', 'icon');
        });
    }
};
