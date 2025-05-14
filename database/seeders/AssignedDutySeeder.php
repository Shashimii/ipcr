<?php

namespace Database\Seeders;

use App\Models\AssignedDuty;
use App\Models\Duty;
use App\Models\Officer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssignedDutySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        // Create 10 duties, 7 officers, and 20 assigned duties
        Duty::factory(10)->create();
        Officer::factory(7)->create();
        AssignedDuty::factory(20)->create();
    }
}
