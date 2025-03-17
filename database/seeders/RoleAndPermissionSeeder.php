<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('permissions')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->call([
            PermissionSeeder::class,
        ]);

        $superadmin = Role::updateOrCreate(
            ['name' => 'Superadmin', 'guard_name' => 'web']
        );

        $superadmin->syncPermissions(Permission::all());
    }
}