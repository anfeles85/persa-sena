<?php

namespace Database\Seeders;

use App\Models\ApprenticeCourse;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApprenticeCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Este codigo crea hasta 5 relaciones automaticamente usando 
         * los datos que se van insertando en la base de datos
         */
        $apprentices = User::where('role_id', 3)->take(5)->pluck('id');
        $courses = Course::take(5)->pluck('id');

        foreach ($apprentices as $i => $apprenticeId) {
            DB::table('apprentice_course')->insert([
                'user_id' => $apprenticeId,
                'course_id' => $courses[$i] ?? $courses->first(),
            ]);
        }
    }
}
