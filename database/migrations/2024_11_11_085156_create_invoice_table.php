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
            $table->date('required_date')->nullable();
            $table->string('order_number')->nullable();
            $table->date('order_date')->nullable();
            $table->integer('is_urgent')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->enum('status', ['pending', 'completed'])->default('pending');
            $table->decimal('invoice_tax_rate', 5, 2)->default(0);
            $table->decimal('total_invoice_tax', 15, 2)->default(0); 
            $table->decimal('items_cost_with_tax', 15, 2)->default(0);
            $table->decimal('items_cost_without_tax', 15, 2)->default(0);
            $table->string('shipped_via')->nullable();
            $table->decimal('shipping_cost', 15, 2)->default(0);
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->decimal('returned_amount', 15, 2)->default(0);
            $table->decimal('due_amount', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->enum('discount_type', ['flat', 'percent'])->default('flat');
            $table->decimal('discount', 15, 2)->default(0);
            $table->enum('payment_status', ['unpaid', 'partial', 'paid'])->default('unpaid');
            $table->text('note')->nullable();
            $table->date('payment_deadline')->nullable();
            $table->timestamp('invoice_date')->useCurrent();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        
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
