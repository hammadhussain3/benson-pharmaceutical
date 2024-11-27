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
        Schema::create('store_issue_requisition_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_issue_requisition_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('raw_material_item_id')->nullable();
            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->integer('quantity');
            $table->string('unit');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total', 15, 2);
            $table->timestamps();

            // Foreign key
            $table->foreign('store_issue_requisition_id')->references('id')->on('store_issue_requisitions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_issue_requisition_items');
    }
};
