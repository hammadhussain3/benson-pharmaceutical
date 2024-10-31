<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            // Add the branch_id column after company_id
            $table->unsignedBigInteger('branch_id')->after('company_id')->nullable();

            // Add a foreign key constraint with cascading delete
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['branch_id']);

            // Drop the branch_id column
            $table->dropColumn('branch_id');
        });
    }
};