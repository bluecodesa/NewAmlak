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
        Schema::table('receipts', function (Blueprint $table) {
           $table->unsignedInteger('invoice_id')->after('owner_id ');

            // Ensure invoice_id references the id column on invoices table
            $table->foreign('invoice_id')
            ->references('id')
            ->on('system_invoices')
            ->onDelete('cascade'); // You can change 'cascade' based on your needs

            // Ensure invoice_id is not nullable
            $table->index('invoice_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('receipts', function (Blueprint $table) {
            //
        });
    }
};
