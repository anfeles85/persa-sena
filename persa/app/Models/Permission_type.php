<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission_type extends Model
{
    use HasFactory;
    protected $table = 'permission_type';
    protected $fillable = [
        'name'
        
    ];

    /**
     * relación con la tabla permissions
     */
    public function permissions(){
        return $this->hasMany(Permission::class);
    }

    
}
