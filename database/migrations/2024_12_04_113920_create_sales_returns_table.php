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
        Schema::create('sales_returns', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedBigInteger('party_id');
            $table->decimal('inclusive_tax', 15, 2);
            $table->decimal('tax_rate', 5, 2);
            $table->decimal('total_tax', 15, 2);
            $table->decimal('exclusive_tax', 15, 2);
            $table->enum('discount_type', ['flat', 'percent'])->default('flat');
            $table->decimal('discount', 15, 2);
            $table->decimal('total_amount', 15, 2);
            $table->boolean('is_approved')->default(false);
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('party_id')->references('id')->on('parties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_returns');
    }
};
