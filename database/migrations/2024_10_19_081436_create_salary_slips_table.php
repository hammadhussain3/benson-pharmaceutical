<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalarySlipsTable extends Migration
{
    public function up()
    {
        Schema::create('salary_slips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade'); // Assuming you have an employees table
            $table->json('leaves')->nullable();
            $table->decimal('late_in_early_out_deduction', 10, 2)->default(0);
            $table->decimal('eob', 10, 2)->default(0);
            $table->decimal('overtime', 10, 2)->default(0);
            $table->decimal('arrears', 10, 2)->default(0);
            $table->decimal('income_tax', 10, 2)->default(0);
            $table->decimal('loan_advance', 10, 2)->default(0);
            $table->enum('payment_mode', ['bank_transfer', 'cash']);
            $table->boolean('is_approved')->default(false);
            $table->foreignId('company_id')->constrained()->onDelete('cascade'); // Assuming you have a companies table
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('salary_slips');
    }
}
