<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstructorCourse extends Model
{
    use HasFactory;
    protected $table = 'instructor_course';
    protected $fillable = [
        'instructor_id',
        'course_id',
    ];

    /**
     * relación con la tabla user
     */
    public function user(){
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * relación con la tabla course
     */
    public function course(){
        return $this->belongsTo(Course::class, 'course_id');
    }
}
