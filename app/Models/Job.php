<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Job extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    public function Employer(){
        return $this->belongsTo(Employer::class, 'employers_id');
    }

    public function field() {
        return $this->belongsTo(Field::class, 'project_field');
    }

    public function section() {
        return $this->belongsTo(Section::class, 'project_section');
    }

    protected $fillable = [
        'id',
        'employers_id',
        'status',
        'address',
        'project_name',
        'project_type',
        'project_description',
        'salary',
        'project_field',
        'project_section',
        'project_deadline',
        'created_at',
        'updated_at'
    ];
}
