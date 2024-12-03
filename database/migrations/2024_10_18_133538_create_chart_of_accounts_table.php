<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chart_of_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('particular');
            $table->string('abbreviation')->nullable();
            $table->decimal('open_debit', 15, 2)->default(0);
            $table->decimal('open_credit', 15, 2)->default(0);
            $table->decimal('act_debit', 15, 2)->default(0);
            $table->decimal('act_credit', 15, 2)->default(0);
            $table->decimal('cl_debit', 15, 2)->default(0);
            $table->decimal('cl_credit', 15, 2)->default(0);
            $table->decimal('budget', 15, 2)->default(0);
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->unique(['code', 'company_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chart_of_accounts');
    }
};
