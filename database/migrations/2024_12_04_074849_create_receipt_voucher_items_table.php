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
        Schema::create('receipt_voucher_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receipt_voucher_id');
            $table->unsignedBigInteger('chart_of_account_id');
            $table->text('description');
            $table->decimal('debit', 10, 2);
            $table->decimal('credit', 10, 2);
            $table->timestamps();

            $table->foreign('receipt_voucher_id')->references('id')->on('receipt_vouchers')->onDelete('cascade');
            $table->foreign('chart_of_account_id')->references('id')->on('chart_of_accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipt_voucher_items');
    }
};
