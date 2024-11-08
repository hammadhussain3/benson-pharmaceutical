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
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps(); // created_at, updated_at

            // Foreign key constraints (if needed)
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
