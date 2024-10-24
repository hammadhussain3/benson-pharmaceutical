<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryTaxSlabsTable extends Migration
{
    public function up()
    {
        Schema::create('salary_tax_slabs', function (Blueprint $table) {
            $table->id();
            $table->decimal('slab_start', 10, 2);
            $table->decimal('slab_end', 10, 2);
            $table->decimal('tax_value', 10, 2);
            $table->foreignId('company_id')->constrained()->onDelete('cascade'); // Assuming there's a companies table
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps(); // This will create created_at and updated_at columns

        });
    }

    public function down()
    {
        Schema::dropIfExists('salary_tax_slabs');
    }
}
