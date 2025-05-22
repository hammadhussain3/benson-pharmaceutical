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
        Schema::create('purchase_requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->date('required_date');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->decimal('total_amount', 15, 2);
            $table->text('special_instructions')->nullable();
            $table->enum('status', ['Pending', 'Complete', 'Partial'])->default('Pending');
            $table->boolean('is_approved')->default(false);
            $table->foreignId('company_id');
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
        Schema::dropIfExists('purchase_requisitions');
    }
};
