<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalaryTaxSlab;

class SalaryTaxSlabSeeder extends Seeder
{
    public function run()
    {
        SalaryTaxSlab::factory()->count(10)->create();
    }
}
