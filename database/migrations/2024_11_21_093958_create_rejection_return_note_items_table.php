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
        Schema::create('rejection_return_note_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rejection_return_note_id')->nullable();
            $table->unsignedBigInteger('raw_material_item_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->decimal('quantity', 10, 2);
            $table->string('unit');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total', 10, 2);
            $table->text('remarks');
            $table->timestamps();

            $table->foreign('rejection_return_note_id')->references('id')->on('rejection_return_notes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rejection_return_note_items');
    }
};
