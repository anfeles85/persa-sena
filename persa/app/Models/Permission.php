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
        'departure_time',
        'reasons',
        'instructor_id',
        'guard_id',
        'status',
        'location_id',
        'permission_type_id'
     ];

    /**
     * relación con la tabla user, instructor_id
     */
    public function instructor_id(){
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * relación con la tabla user, guard_id
     */
    public function guard_id(){
        return $this->belongsTo(Instructor_course::class, 'guard_id');
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
    public function permission_type(){
        return $this->belongsTo(Permission_type::class, 'location_id');
    }


}
