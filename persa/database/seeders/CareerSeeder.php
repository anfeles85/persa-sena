<?php

namespace Database\Seeders;

use App\Models\Career;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CareerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Career::insert([
            [
                'name' => 'SST',
                'type' => 'TECNICO'
            ],
            [
                'name' => 'ADSO',
                'type' => 'TECNOLOGO'
            ],
            [
                'name' => 'Gestión documental',
                'type' => 'TECNICO'
            ],
            [
                'name' => 'Enfermeria',
                'type' => 'TECNOLOGO'
            ],
            [
                'name' => 'Deporte',
                'type' => 'TECNICO'
            ]

        ]);
    }
}
