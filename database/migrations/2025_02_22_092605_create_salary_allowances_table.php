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
        if (!Schema::hasTable('salary_allowances')) {
            Schema::create('salary_allowances', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('salary_slip_id');
                $table->unsignedBigInteger('employee_id');
                $table->string('name');
                $table->decimal('amount', 10, 2);
                $table->string('type');
                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->timestamps();

                $table->foreign('salary_slip_id')->references('id')->on('salary_slips')->onDelete('cascade');
                $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_allowances');
    }
};
