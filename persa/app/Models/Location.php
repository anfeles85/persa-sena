<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $table = 'location';
    protected $fillable =[
        'name',
        'address'
    ];

    /**
     * relación con la tabla permissions
     */
     public function permissions(){
        return $this->hasMany(Permission::class);
    }
}
