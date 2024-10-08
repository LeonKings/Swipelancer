<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public function Users(){
        return $this->hasMany(User::class);
    }
    
    protected $fillable = [
        'id',
        'role_name',
        'created_at',
        'updated_at'
    ];
}