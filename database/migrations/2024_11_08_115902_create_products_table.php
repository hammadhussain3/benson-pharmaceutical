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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('reg_no');
            $table->string('name');
            $table->string('generic_name');
            $table->string('brand_name');
            $table->string('therapeutic_class');
            $table->string('code');
            $table->unsignedBigInteger('product_group_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            // Foreign key
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('product_group_id')->references('id')->on('product_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
