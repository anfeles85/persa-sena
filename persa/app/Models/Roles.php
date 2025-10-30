<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    protected $table = 'roles';
    
    protected $fillable = [
        'name'
    ];

    /**
     * Se establece relacion entre tabla roles y users
     */
    public function user(){
        return $this->hasMany(User::class);
    }
}
