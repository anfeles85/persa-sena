<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    /**
     * se crean los atributos de la tabla 
     * 
     */

     protected $table = 'permission';
     protected $fillable =[
        'permission_date',
        'start_time',
        'end_time',
        'departure_time',
        'reasons',
        'instructor_id',
        'guard_id',
        'status',
        'location_id',
        'permission_type_id',
        'apprentice_id'
     ];

    /**
     * relación con la tabla user, instructor_id
     */
    public function instructor_user(){
        return $this->belongsTo(User::class, 'instructor_id');
    }

     /**
     * relación con la tabla user, instructor_id
     */
    public function apprentice_user(){
        return $this->belongsTo(User::class, 'apprentice_id');
    }

    /**
     * relación con la tabla user, guard_id
     */
    public function guard_user(){
        return $this->belongsTo(InstructorCourse::class, 'guard_id');
    }

    /**
     * relación con la tabla location
     */
    public function location(){
        return $this->belongsTo(Location::class, 'location_id');
    }
    
    /**
     * relación con la tabla permission_type
     */
    public function permissionType(){
        return $this->belongsTo(PermissionType::class, 'permission_type_id');
    }


}
