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
            $table->unsignedBigInteger('created_by'); // created_by field
            $table->unsignedBigInteger('updated_by')->nullable(); // updated_by field
            $table->timestamps(); // created_at, updated_at

            // Foreign key constraints (if needed)
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
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
