<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprenticeCourse extends Model
{
    use HasFactory;
    protected $table = 'apprentice_course';
    protected $fillable = [
        'user_id',
        'course_id',
    ];

    /**
     * relación con la tabla user
     */
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * relación con la tabla course
     */
    public function course(){
        return $this->belongsTo(Course::class, 'course_id');
    }
}
