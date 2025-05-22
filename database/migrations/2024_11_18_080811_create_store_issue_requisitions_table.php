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
        Schema::create('store_issue_requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('chart_of_account_id')->nullable();
            $table->integer('product_variation_id')->nullable();
            $table->unsignedBigInteger('batch_id')->nullable();
            $table->string('dn_gp');
            $table->boolean('is_approved')->default(false);
            $table->unsignedBigInteger('company_id');
            $table->integer('is_general');
            $table->integer('is_production');
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
        Schema::dropIfExists('store_issue_requisition');
    }
};