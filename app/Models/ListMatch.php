<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class listMatch extends Model
{
    use HasFactory;
    public function Freelancer(){
        return $this->hasMany(Freelancer::class);
    }
    public function Job(){
        return $this->hasMany(Job::class);
    }
    protected $fillable = [
        'id',
        'freelancer_id',
        'job_id',
        'freelancer_status',
        'job_status',
        'status',
        'created_at',
        'updated_at'
    ];
}
