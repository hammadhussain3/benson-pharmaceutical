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
        Schema::create('goods_receiving_vendor_bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('goods_receiving_id')->constrained('goods_receivings')->onDelete('cascade');
            $table->unsignedInteger('item_index'); // Index of the item in the GRN
            $table->string('bill_no'); // Vendor bill number
            $table->date('bill_date')->nullable(); // Bill date
            $table->decimal('amount', 15, 2)->default(0); // Bill amount
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index(['goods_receiving_id', 'item_index']);
            $table->index('bill_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_receiving_vendor_bills');
    }
};
