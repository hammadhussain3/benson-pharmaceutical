<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bank;

class BankSeeder extends Seeder
{
    public function run()
    {
        Bank::factory()->count(10)->create();
    }
}
