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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->unsignedBigInteger('raw_material_item_id')->nullable();
            $table->unsignedBigInteger('batch_id')->nullable();
            $table->string('trans_code')->nullable();
            $table->string('unit');
            $table->decimal('unit_price', 15, 2);
            $table->integer('quantity');
            $table->decimal('tax_rate', 5, 2)->nullable();
            $table->enum('discount_type', ['flat', 'percent'])->default('flat');
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
