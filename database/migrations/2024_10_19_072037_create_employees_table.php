<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->decimal('basic_pay', 10, 2);
            $table->decimal('allowances', 10, 2);
            $table->decimal('net_salary', 10, 2)->virtualAs('basic_pay + allowances');
            $table->date('date_of_joining');
            $table->foreignId('designation_id')->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->foreignId('bank_id')->nullable()->constrained()->onDelete('set null');
            $table->string('bank_account')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
