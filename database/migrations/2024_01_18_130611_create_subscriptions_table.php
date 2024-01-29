<?php
// database/migrations/xxxx_xx_xx_create_subscriptions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('office_id')->unsigned();
            $table->tinyInteger('new_by_admin')->default(0);
            $table->tinyInteger('notified')->default(0);
            $table->integer('subscription_type_id')->nullable();
            $table->tinyInteger('is_renewed')->default(0);
            $table->string('date_start')->nullable();
            $table->string('date_end')->nullable();
            $table->string('extended_date')->nullable();
            $table->string('total')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('status');
            $table->tinyInteger('is_deleted')->default(0);
            $table->timestamps();

            $table->foreign('office_id')->references('id')->on('offices');
            // $table->foreignId('subscription_type_id')->constrained('subscription_types');
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}
