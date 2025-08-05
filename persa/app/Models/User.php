<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fullname',
        'email',
        'password',
        'status',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * relación con la tabla roles
     */
    public function role(){
        return $this->belongsTo(Roles::class, 'role_id');
    }
    
    /**
     * relación con la tabla permission
     */
    public function instructorPermissions(){
        return $this->hasMany(Permission::class, 'instructor_id');
    }
    
    /**
     * relación con la tabla permission
     */
    public function guardPermissions(){
        return $this->hasMany(Permission::class, 'guard_id');
    }


    /**
     * relación con la tabla apprentice_course
     */
    public function apprenticeCourses(){
        return $this->belongsToMany(Course::class, 'apprentice_course', 'user_id', 'course_id');
    }
  
    /**
     * relación con la tabla instrcutor_course
     */
    public function instructorCourses(){
        return $this->belongsToMany(Course::class, 'instructor_course', 'instructor_id', 'course_id');
    }

    public function apprenticeCourse()
    {
       return $this->hasOne(\App\Models\ApprenticeCourse::class, 'user_id');
    }

    public function permissions()
    {
    return $this->hasMany(Permission::class, 'apprentice_id');
    }
        
}
