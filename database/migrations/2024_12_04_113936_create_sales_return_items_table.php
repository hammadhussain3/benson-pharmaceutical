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
        Schema::create('sales_return_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_return_id');
            $table->unsignedBigInteger('product_variation_id');
            $table->unsignedBigInteger('batch_id')->nullable();
            $table->string('unit');
            $table->decimal('unit_price', 15, 2);
            $table->integer('quantity');
            $table->decimal('tax_rate', 5, 2)->nullable();
            $table->enum('discount_type', ['flat', 'percent'])->default('flat');
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();

            $table->foreign('sales_return_id')->references('id')->on('sales_returns')->onDelete('cascade');
            $table->foreign('product_variation_id')->references('id')->on('product_variations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_return_items');
    }
};
