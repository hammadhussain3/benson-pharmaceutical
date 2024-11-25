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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('raw_material_item_id')->nullable();
            $table->unsignedBigInteger('batch_id')->nullable();
            $table->unsignedBigInteger('goods_receiving_id')->nullable();
            $table->unsignedBigInteger('finished_goods_receiving_id')->nullable();
            $table->unsignedBigInteger('store_issue_requisition_id')->nullable();
            $table->unsignedBigInteger('rejection_return_note_id')->nullable();
            $table->unsignedBigInteger('left_over_note_id')->nullable();
            $table->integer('quantity');
            $table->string('unit');
            $table->decimal('unit_price', 8, 2);
            $table->decimal('total', 10, 2);
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            // Foreign key
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
