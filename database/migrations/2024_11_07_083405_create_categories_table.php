<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // id field
            $table->string('name'); // name field
            $table->string('prefix'); // prefix field
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

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
