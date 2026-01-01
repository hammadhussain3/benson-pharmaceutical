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
        Schema::create('left_over_note_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('left_over_note_id');
            $table->unsignedBigInteger('raw_material_item_id');
            $table->decimal('quantity', 10, 2);
            $table->string('unit');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total', 10, 2);
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('left_over_note_id')->references('id')->on('left_over_notes')->onDelete('cascade');
            $table->foreign('raw_material_item_id')->references('id')->on('raw_material_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('left_over_note_items');
    }
};
