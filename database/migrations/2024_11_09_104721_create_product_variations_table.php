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
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('reg_no');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('dosage_form_id');
            $table->unsignedBigInteger('pack_form_id')->nullable();
            $table->unsignedBigInteger('packing_type_id');
            $table->unsignedBigInteger('pack_size_id');
            $table->decimal('trade_price', 10, 2);
            $table->decimal('our_mrp', 10, 2);
            $table->decimal('drap_mrp', 10, 2);
            $table->string('min_level');
            $table->string('max_level');
            $table->unsignedBigInteger('product_group_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            // Foreign key
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('dosage_form_id')->references('id')->on('dosage_forms')->onDelete('cascade');
            $table->foreign('pack_form_id')->references('id')->on('pack_forms')->onDelete('cascade');
            $table->foreign('packing_type_id')->references('id')->on('packing_types')->onDelete('cascade');
            $table->foreign('pack_size_id')->references('id')->on('pack_sizes')->onDelete('cascade');
            $table->foreign('product_group_id')->references('id')->on('product_groups')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variations');
    }
};
