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
                'status' => 'APROBADO',
            ],
            [
                'permission_date' => '2023-10-02',
                'start_time' => '10:00:00',
                'end_time' => '12:00:00',
                'departure_time' => '10:15:00',
                'reasons' => 'CALAMIDAD DOMESTICA',
                'status' => 'PENDIENTE',
            ],
            [
                'permission_date' => '2023-10-03',
                'start_time' => '11:00:00',
                'end_time' => '13:00:00',
                'departure_time' => '11:15:00',
                'reasons' => 'ENTREVISTA ETAPA PRODUCTIVA',
                'status' => 'APROBADO',
            ],
            [
                'permission_date' => '2023-10-04',
                'start_time' => '12:00:00',
                'end_time' => '14:00:00',
                'departure_time' => '12:15:00',
                'reasons' => 'OTRO',
                'status' => 'DESAPROBADO',
            ],
            [
                'permission_date' => '2023-10-05',
                'start_time' => '13:00:00',
                'end_time' => '14:30:00',
                'departure_time' => '13:15:00',
                'reasons' => 'CITA MEDICA',
                'status' => 'APROBADO',
            ],
        ]); 
        }
    }