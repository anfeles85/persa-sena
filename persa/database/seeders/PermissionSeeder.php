<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::insert([
           [
                'permission_date' => '2023-10-01',
                'start_time' => '09:00:00',
                'end_time' => '10:00:00',
                'departure_time' => '09:15:00',
                'reasons' => 'CITA MEDICA',
                'instructor_id' => 1,
                'apprentice_id' => 1,
                'guard_id' => 4,
                'status' => 'APROBADO',
                'location_id' => 1,
                'permission_type_id' => 1,
            ],
            [
                'permission_date' => '2023-10-02',
                'start_time' => '10:00:00',
                'end_time' => '12:00:00',
                'departure_time' => '10:15:00',
                'reasons' => 'CALAMIDAD DOMESTICA',
                'instructor_id' => 2,
                'apprentice_id' => 2,
                'guard_id' => 5,
                'status' => 'PENDIENTE',
                'location_id' => 2,
                'permission_type_id' => 4,
            ],
            [
                'permission_date' => '2023-10-03',
                'start_time' => '11:00:00',
                'end_time' => '13:00:00',
                'departure_time' => '11:15:00',
                'reasons' => 'ENTREVISTA ETAPA PRODUCTIVA',
                'instructor_id' => 3,
                'apprentice_id' => 3,
                'guard_id' => 4,
                'status' => 'APROBADO',
                'location_id' => 3,
                'permission_type_id' => 1,
            ],
            [
                'permission_date' => '2023-10-04',
                'start_time' => '12:00:00',
                'end_time' => '14:00:00',
                'departure_time' => '12:15:00',
                'reasons' => 'OTRO',
                'instructor_id' => 4,
                'apprentice_id' => 4,
                'guard_id' => 5,
                'status' => 'DESAPROBADO',
                'location_id' => 2,
                'permission_type_id' => 3,
            ],
            [
                'permission_date' => '2023-10-05',
                'start_time' => '13:00:00',
                'end_time' => '14:30:00',
                'departure_time' => '13:15:00',
                'reasons' => 'CITA MEDICA',
                'instructor_id' => 5,
                'apprentice_id' => 5,
                'guard_id' => 4,
                'status' => 'APROBADO',
                'location_id' => 1,
                'permission_type_id' => 1,
            ]
        ]); 
        }
    }