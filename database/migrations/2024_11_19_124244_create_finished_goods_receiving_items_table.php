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
        Schema::create('finished_goods_receiving_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('finished_goods_receiving_id');
            $table->unsignedBigInteger('product_variation_id');
            $table->decimal('quantity_received', 10, 2);
            $table->string('unit');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total', 10, 2);
            $table->timestamps();

            $table->foreign('finished_goods_receiving_id', 'fgr_items_fgr_id_foreign')->references('id')->on('finished_goods_receivings')->onDelete('cascade');
            $table->foreign('product_variation_id')->references('id')->on('product_variations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finished_goods_receiving_items');
    }
};
