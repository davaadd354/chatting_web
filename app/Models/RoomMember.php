<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MessageRoom;
use App\Models\Message;
use App\Models\User;



class RoomMember extends Model
{
    use HasFactory;


    public function dataRoom(){
        return $this->belongsTo(MessageRoom::class, 'room_id', 'id');
    }

    // public function detailUser(){
    //     return $this->hasOne(User::class, 'id', 'room_id');
    // }

}
