<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('model_has_roles', function (Blueprint $table) {
            // Drop the foreign key constraint on the role_id column (if it exists)
            $table->dropForeign(['role_id']);

            // Drop the existing primary key on the 'role_id' column
            $table->dropPrimary();

            // Drop model_type and model_id columns if they exist
            if (Schema::hasColumn('model_has_roles', 'model_type')) {
                $table->dropColumn('model_type');
            }
            if (Schema::hasColumn('model_has_roles', 'model_id')) {
                $table->dropColumn('model_id');
            }

            // Add the user_id column
            $table->unsignedBigInteger('user_id')->after('role_id');

            // Set composite primary key on role_id and user_id
            $table->primary(['role_id', 'user_id']);

            // Add foreign key constraint on user_id referencing id on users table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('model_has_roles', function (Blueprint $table) {
            // Drop the composite primary key
            $table->dropPrimary(['role_id', 'user_id']);

            // Drop the foreign key constraint
            $table->dropForeign(['user_id']);

            // Drop user_id column
            $table->dropColumn('user_id');

            // Re-add model_type and model_id columns if needed
            $table->unsignedBigInteger('model_id');
            $table->string('model_type');

            // Revert to the original primary key on role_id
            $table->primary(['role_id']);
        });
    }
};