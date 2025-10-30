<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::insert([
            [
                'number_group' => '2921889',
                'shift' => 'DIURNA',
                'trimester' => 'T1',
                'year' => 2023,
                'status' => 'ACTIVO',
                'career_id' => 1
            ],
            [
                'number_group' => '2921881',
                'shift' => 'NOCTURNA',
                'trimester' => 'T2',
                'year' => 2023,
                'status' => 'ACTIVO',
                'career_id' => 2
            ],
            [
                'number_group' => '3257211',
                'shift' => 'DIURNA',
                'trimester' => 'T3',
                'year' => 2025,
                'status' => 'ACTIVO',
                'career_id' => 3
            ],
            [
                'number_group' => '4374821',
                'shift' => 'DIURNA',
                'trimester' => 'T4',
                'year' => 2023,
                'status' => 'INACTIVO',
                'career_id' => 4
            ]
        ]);
    }
}
