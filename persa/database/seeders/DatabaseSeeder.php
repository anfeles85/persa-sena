<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this ->call(RolesSeeder::class);
        $this ->call(CareerSeeder::class);
        $this ->call(CourseSeeder::class);
        $this ->call(LocationSeeder::class);

         //crear 2 usuario de rol coordinador
        User::factory(2)->create([
            'role_id' => 1
        ]);

        //crear 5 usuario de rol instructor
        User::factory(5)->create([
            'role_id' => 2
        ]);

        //crear 3 usuario de rol aprendiz
        User::factory(5)->create([
            'role_id' => 3
        ]);
       
        //crear 2 usuario de rol guarda
        User::factory(2)->create([
            'role_id' => 4
        ]);
        
        $this ->call(PermissionTypeSeeder::class);
        $this ->call(InstructorCourseSeeder::class);
        $this ->call(ApprenticeCourseSeeder::class);
        $this ->call(PermissionSeeder::class);
    }
}
