<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmployeeIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->default(0)->after('id'); // Add employee_id column with default value 0
            // If you want to create a foreign key constraint, uncomment the line below
            // $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set null'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key if it was added
            // $table->dropForeign(['employee_id']); 
            $table->dropColumn('employee_id'); // Remove employee_id column
        });
    }
}