<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'fullname',
        'email',
        'document',
        'password',
        'status',
        'role_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relación con roles
    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }

    // Relación con permisos donde es instructor
    public function instructorPermissions()
    {
        return $this->hasMany(Permission::class, 'instructor_id');
    }

    // Relación con permisos donde es guardia
    public function guardPermissions()
    {
        return $this->hasMany(Permission::class, 'guard_id');
    }

    // Relación con permisos donde es aprendiz
    public function permissions()
    {
        return $this->hasMany(Permission::class, 'apprentice_id');
    }

    // Relación con cursos del aprendiz
    public function apprenticeCourses()
    {
        return $this->belongsToMany(Course::class, 'apprentice_course', 'user_id', 'course_id');
    }

    // Alias opcional más genérico
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'apprentice_course', 'user_id', 'course_id');
    }

    // Relación con cursos del instructor
    public function instructorCourses()
    {
        return $this->belongsToMany(Course::class, 'instructor_course', 'instructor_id', 'course_id');
    }
}