<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $table = 'course';
    protected $fillable =[
        'number_group',
        'shift',
        'trimester',
        'year',
        'status',
        'career_id'
    ];

     public function career(){
        return $this->belongsTo(Career::class, 'career_id');
    }

    /**
     * relación con la tabla apprentice_course
     */
    public function apprentices(){
        return $this->belongsToMany(User::class, 'apprentice_course', 'course_id', 'user_id')
            ->where('role_id', 3); 
            
    }
  
    /**
     * relación con la tabla instrcutor_course
     */
    public function instructorCourses(){
       return $this->belongsToMany(User::class, 'instructor_course', 'instructor_id', 'course_id');

    }


}