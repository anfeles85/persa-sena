<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $table = 'course';
    protected $fillable =[
        'shift',
        'trimester',
        'year',
        'status',
        'career_id'
    ];

     public function carrer(){
        return $this->belongsTo(Career::class, 'career_id');
    }

    /**
     * relación con la tabla apprentice_course
     */
    public function apprentice_Courses(){
        return $this->belongsToMany(User::class, 'apprentice_course', 'user_id', 'course_id');
    }
  
    /**
     * relación con la tabla instrcutor_course
     */
    public function instructor_Courses(){
        return $this->belongsToMany(User::class, 'instrcutor_course', 'instructor_id', 'course_id');
    }


}
