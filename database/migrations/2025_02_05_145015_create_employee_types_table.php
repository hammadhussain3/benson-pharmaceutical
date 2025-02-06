<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('employee_types', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->foreignId('employee_type_id')->nullable()->constrained('employee_types')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['employee_type_id']);
            $table->dropColumn('employee_type_id');
        });

        Schema::dropIfExists('employee_types');
    }
};