<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUniqueConstraintFromEmployeesCode extends Migration
{
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            // Assuming the unique constraint was named 'employees_code_unique'
            $table->dropUnique(['code']);
        });
    }

    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            // If you need to add it back, do it here
            $table->unique('code');
        });
    }
}