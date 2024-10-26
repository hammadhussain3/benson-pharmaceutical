<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMonthYearToSalarySlipsTable extends Migration
{
    public function up()
    {
        Schema::table('salary_slips', function (Blueprint $table) {
            $table->unsignedTinyInteger('month')->after('payment_mode');
            $table->unsignedSmallInteger('year')->after('month');
        });
    }

    public function down()
    {
        Schema::table('salary_slips', function (Blueprint $table) {
            $table->dropColumn(['month', 'year']);
        });
    }
}