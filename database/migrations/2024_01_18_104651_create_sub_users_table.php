<?php

// database/migrations/xxxx_xx_xx_create_sub_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubUsersTable extends Migration
{
    public function up()
    {
        Schema::create('sub_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('office_id')->constrained('offices');
            $table->foreignId('user_id')->constrained('users');
            $table->string('email')->unique();
            $table->boolean('is_default')->default(false);
            $table->tinyInteger('pass_from_admin')->default(0);
            $table->string('password');
            $table->string('userType');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sub_users');
    }
}
