<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('property_masterplan')->nullable()->after('lat_long');
            $table->string('property_brochure')->nullable()->after('property_masterplan');
            $table->longText('note')->nullable()->after('property_brochure');
            $table->tinyInteger('show_in_gallery')->default(1)->after('note');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('property_masterplan');
            $table->dropColumn('property_brochure');
            $table->dropColumn('note');
            $table->dropColumn('show_in_gallery');
        });
    }
}
