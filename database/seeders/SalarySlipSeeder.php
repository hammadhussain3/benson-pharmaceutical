<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalarySlip;

class SalarySlipSeeder extends Seeder
{
    public function run()
    {
        SalarySlip::factory()->count(30)->create();
    }
}
