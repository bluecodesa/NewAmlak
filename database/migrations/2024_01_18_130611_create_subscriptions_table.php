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
            $table->increments('id');
            $table->unsignedBigInteger('office_id')->nullable();
            $table->integer('broker_id')->unsigned()->nullable();
            $table->integer('subscription_type_id')->unsigned()->nullable();
            $table->string('status');
            $table->boolean('renewed_by_admin')->default(0);
            $table->boolean('notified')->default(0);
            $table->boolean('is_end')->default(0);
            $table->boolean('is_start')->default(0);
            $table->boolean('is_new')->default(0);
            $table->boolean('is_suspend')->default(0);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->double('total', 8, 2)->nullable();
            $table->string('payment_type')->nullable();
            $table->foreign('subscription_type_id')->references('id')->on('subscription_types')->onDelete('cascade');
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
            $table->foreign('broker_id')->references('id')->on('brokers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}
