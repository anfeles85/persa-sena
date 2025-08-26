<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    /**
     * Se crean los atributos de la tabla
     */

    protected $table = 'permission';

    protected $fillable = [
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
        'apprentice_id',
        'career_id'
    ];

    /**
     * Relación con users: instructor_id → users.id
     */
    public function instructor_user(){
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * Relación con users: apprentice_id → users.id
     */
    public function apprentice_user(){
        return $this->belongsTo(User::class, 'apprentice_id')->where('role_id', 3);
    }

    /**
     *  Relación con users: guard_id → users.id
     */
    public function guard_user(){
        return $this->belongsTo(User::class, 'guard_id');
    }

    /**
     * Relación con location: location_id → location.id
     */
    public function location(){
        return $this->belongsTo(Location::class, 'location_id');
    }

    /**
     * Relación con permission_type: permission_type_id → permission_type.id
     */
    public function permissionType(){
        return $this->belongsTo(PermissionType::class, 'permission_type_id');
    }

    /**
     * Relación con career: carrer_id → career.id
     */
    public function career()
    {
        return $this->belongsTo(Career::class, 'career_id');
    }

   
}
