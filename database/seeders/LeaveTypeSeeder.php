<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('leave_types')->insert([
            [
                'id' => 1,
                'name' => 'Authorized Absence',
                'company_id' => 1,
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => '2024-10-31 05:51:31',
                'updated_at' => '2024-10-31 05:51:31',
            ],
            [
                'id' => 2,
                'name' => 'Unauthorized Absence',
                'company_id' => 1,
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => '2024-10-31 05:51:51',
                'updated_at' => '2024-10-31 05:51:51',
            ],
            [
                'id' => 3,
                'name' => 'Approved Leave with Pay',
                'company_id' => 1,
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => '2024-10-31 05:52:12',
                'updated_at' => '2024-10-31 05:52:12',
            ],
        ]);
    }
}