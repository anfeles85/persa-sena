<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\InstructorCourse;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstructorCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Este codigo crea hasta 5 relaciones automaticamente usando 
         * los datos que se van insertando en la base de datoss
         */
        $instructors = User::where('role_id', 2)->take(5)->pluck('id');
        $courses = Course::take(5)->pluck('id');

        foreach ($instructors as $i => $instructorId) {
            DB::table('instructor_course')->insert([
                'instructor_id' => $instructorId,
                'course_id' => $courses[$i] ?? $courses->first(), 
            ]);
    }
    }
}
