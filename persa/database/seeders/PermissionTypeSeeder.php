<?php

namespace Database\Seeders;

use App\Models\PermissionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PermissionType::insert([
            ['name' => 'CITA MEDICA'],
            ['name' => 'CALAMIDAD DOMESTICA'],
            ['name' => 'ENTREVISTA ETAPA PRODUCTIVA'],
            ['name' => 'OTRO']
        ]);
    }
}
