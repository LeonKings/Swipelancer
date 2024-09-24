<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{

    use HasApiTokens, HasFactory, Notifiable;
    public function Role(){
        return $this->hasOne(Role::class);
    }
    public function Freelancer(){
        return $this->hasOne(Freelancer::class);
    }
    public function Employer(){
        return $this->hasOne(Employer::class);
    }
    protected $fillable = [
        'id',
        'email',
        'password',
        'role_id',
        'plan',
        'subscribe_until',
        'swipe_count',
        'swipe_date',
        'created_at',
        'updated_at'
    ];
    protected $cast = [
        'email_verified_at' => 'datetime'
    ];
}

