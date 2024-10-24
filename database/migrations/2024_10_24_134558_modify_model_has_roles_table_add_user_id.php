<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('model_has_roles', function (Blueprint $table) {
            // Drop the model_type and model_id columns
            if (Schema::hasColumn('model_has_roles', 'model_type')) {
                $table->dropColumn('model_type');
            }
            if (Schema::hasColumn('model_has_roles', 'model_id')) {
                $table->dropColumn('model_id');
            }

            // Add the user_id column
            $table->unsignedBigInteger('user_id')->after('role_id');

            // If you want to add a foreign key constraint:
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('model_has_roles', function (Blueprint $table) {
            // Reverse the changes made in the 'up' method
            $table->dropColumn('user_id');

            // Re-add model_type and model_id columns if needed
            $table->unsignedBigInteger('model_id');
            $table->string('model_type');

            // Define the index again for optimization
            $table->index(['model_id', 'model_type'], 'model_id_model_type_index');
        });
    }
};