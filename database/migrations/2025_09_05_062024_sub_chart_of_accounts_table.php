<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_chart_of_accounts', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->foreignId('chart_of_account_id')
                  ->constrained('chart_of_accounts')
                  ->cascadeOnDelete();

            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->cascadeOnDelete();

            $table->foreignId('company_id')
                  ->constrained('companies')
                  ->cascadeOnDelete();

            $table->foreignId('created_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->foreignId('updated_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamps();

            // Optional but senior-level indexing
            $table->index(['company_id', 'chart_of_account_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_chart_of_accounts');
    }
};
