<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::insert([
            [
                'name' => 'SAGRADO',
                'address' => 'Cra 25 # 24-47'
            ],
            [
                'name' => 'SALESIANO',
                'address' => 'Cra 26 # 34-40 B'
            ],
            [
                'name' => 'BICENTENARIO',
                'address' => 'Cl 28 # 19-38'
                ]
        ]);
    }
}
