<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    use HasFactory;
    public function User(){
        return $this->belongsTo(User::class,'users_id');
    }

    protected $fillable = [
        'id',
        'community_name',
        'community_desc',
        'community_url',
        'users_id',
        'created_at',
        'updated_at'
    ];
}
