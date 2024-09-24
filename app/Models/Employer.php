<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Employer extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    public function User(){
        return $this->belongsTo(User::class,'users_id');
    }
    public function Job(){
        return $this->hasMany(Job::class);
    }
    protected $fillable = [
        'id',
        'users_id',
        'employer_image_link',
        'employer_type',
        'employer_name',
        'job_count',
        'created_at',
        'updated_at'
    ];
}
