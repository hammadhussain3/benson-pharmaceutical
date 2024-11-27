<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->enum('type', ['sale', 'purchase', 'quotation']);
            $table->string('prefix', 5);
            $table->unsignedBigInteger('party_id');
            $table->date('required_date');
            $table->integer('is_urgent');
            $table->unsignedBigInteger('company_id');
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->decimal('invoice_tax_rate', 5, 2);
            $table->decimal('total_invoice_tax', 15, 2); 
            $table->decimal('items_cost_with_tax', 15, 2);
            $table->decimal('items_cost_without_tax', 15, 2);
            $table->decimal('shipping_cost', 15, 2)->default(0);
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->decimal('returned_amount', 15, 2)->default(0);
            $table->decimal('due_amount', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2);
            $table->enum('discount_type', ['flat', 'percent']);
            $table->decimal('discount', 15, 2);
            $table->enum('payment_status', ['unpaid', 'partial', 'paid'])->default('unpaid');
            $table->text('note')->nullable();
            $table->date('payment_deadline');
            $table->timestamp('invoice_date')->useCurrent();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        
            // Foreign key constraints
            $table->foreign('party_id')->references('id')->on('parties')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
