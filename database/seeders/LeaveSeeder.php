<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Leave;

class LeaveSeeder extends Seeder
{
    public function run()
    {
        Leave::factory()->count(30)->create();
    }
}
