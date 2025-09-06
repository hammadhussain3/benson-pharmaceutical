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
        Schema::table('master_formulations', function (Blueprint $table) {
            $table->unsignedBigInteger('raw_material_item_id')->nullable()->after('id');
            $table->foreign('raw_material_item_id')
                  ->references('id')->on('raw_material_items')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('master_formulations', function (Blueprint $table) {
            $table->dropForeign(['raw_material_item_id']);
            $table->dropColumn('raw_material_item_id');
        });
    }
};
