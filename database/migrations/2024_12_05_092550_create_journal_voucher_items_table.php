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
        Schema::create('journal_voucher_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('journal_voucher_id');
            $table->unsignedBigInteger('chart_of_account_id');
            $table->text('description');
            $table->decimal('debit', 10, 2);
            $table->decimal('credit', 10, 2);
            $table->timestamps();

            $table->foreign('journal_voucher_id')->references('id')->on('journal_vouchers')->onDelete('cascade');
            $table->foreign('chart_of_account_id')->references('id')->on('chart_of_accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_voucher_items');
    }
};
