<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeShowGalleryToShowInGalleryInUnitsTable extends Migration
{
    public function up()
    {
        Schema::table('units', function (Blueprint $table) {
            // Change `show_gallery` to `show_in_gallery` with default value of 1
            $table->renameColumn('show_gallery', 'show_in_gallery');
            $table->boolean('show_in_gallery')->default(1)->change();
        });
    }

    public function down()
    {
        Schema::table('units', function (Blueprint $table) {
            // Reverse the changes: rename `show_in_gallery` back to `show_gallery`
            $table->renameColumn('show_in_gallery', 'show_gallery');
            $table->boolean('show_gallery')->default(0)->change(); // Adjust this default if necessary
        });
    }
}
