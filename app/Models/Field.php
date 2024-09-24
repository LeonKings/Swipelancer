<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Field extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    public function section() {
        return $this->hasMany(Section::class, 'fields_id');
    }
}
