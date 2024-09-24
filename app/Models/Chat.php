<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    public function Sender(){
        return $this->belongsTo(User::class,'sender');
    }
    public function Chat_with(){
        return $this->belongsTo(User::class,'chat_with');
    }

    protected $fillable = [
        'id',
        'sender',
        'message',
        'chat_with',
        'created_at',
        'updated_at'
    ];
}
