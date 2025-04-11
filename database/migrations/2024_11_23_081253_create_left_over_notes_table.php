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
        Schema::create('left_over_notes', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('batch_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('store_issue_requisition_id');
            $table->boolean('is_approved')->default(false);
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            // Foreign key
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('store_issue_requisition_id')->references('id')->on('store_issue_requisitions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('left_over_notes');
    }
};