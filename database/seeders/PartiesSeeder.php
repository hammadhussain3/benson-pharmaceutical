<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parties;
use App\Models\Party;

class PartiesSeeder extends Seeder
{
    public function run()
    {
        Party::factory()->count(30)->create();
    }
}
