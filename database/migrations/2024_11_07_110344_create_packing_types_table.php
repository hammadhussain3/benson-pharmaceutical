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
        Schema::create('packing_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // name field
            $table->text('description')->nullable(); // description field
            $table->unsignedBigInteger('company_id'); // company_id field
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps(); // created_at, updated_at

            // Foreign key constraints (if needed)
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packing_types');
    }
};
