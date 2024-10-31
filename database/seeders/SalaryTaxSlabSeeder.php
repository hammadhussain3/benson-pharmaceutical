<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalaryTaxSlabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('salary_tax_slabs')->insert([
            [
                'id' => 1,
                'slab_start' => '0.00',
                'slab_end' => '600000.00',
                'tax_value' => '0.00',
                'company_id' => 1,
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'slab_start' => '600000.00',
                'slab_end' => '1200000.00',
                'tax_value' => '5.00',
                'company_id' => 1,
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'slab_start' => '1200000.00',
                'slab_end' => '2200000.00',
                'tax_value' => '12.50',
                'company_id' => 1,
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'slab_start' => '22000000.00',
                'slab_end' => '32000000.00',
                'tax_value' => '25.00',
                'company_id' => 1,
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}