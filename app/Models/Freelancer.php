<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Freelancer extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    public function user() {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function field() {
        return $this->belongsTo(Field::class, 'field_of_work');
    }

    public function section1() {
        return $this->belongsTo(Section::class, 'section_1');
    }

    public function section2() {
        return $this->belongsTo(Section::class, 'section_2');
    }

    public function section3() {
        return $this->belongsTo(Section::class, 'section_3');
    }

    protected $fillable = [
        'id',
        'users_id',
        'freelancer_image_link',
        'freelancer_name',
        'last_study',
        'field_of_work',
        'cv_link',
        'portfolio',
        'min_salary',
        'max_salary',
        'section_1',
        'section_2',
        'section_3',
        'describe_yourselves',
        'created_community',
        'created_at',
        'updated_at'
    ];
}
