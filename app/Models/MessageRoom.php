<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\RoomMember;
use App\Models\Message;
use App\Models\User;
use Auth;

class MessageRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'channel',
        'type'
    ];

    protected $appends = ['channel_name','status'];

    public function dataMember(){
        return $this->hasMany(RoomMember::class, 'room_id', 'id');
    }

    public function dataChat(){
        return $this->hasMany(Message::class, 'room_id', 'id');
    }

    public function getChannelNameAttribute(){
        if($this->type == 2){
            return $this->name;
        }else{
            foreach($this->dataMember as $member){
                if(Auth::user()->id != $member->user_id){
                    $user = DB::table('users')->where('id', $member->user_id)->first();
                    return $user->name;
                }
            }
        }
    }

    public function getStatusAttribute(){
        if($this->type == 2){
            return null;
        }else{
            $users = DB::table('room_members')->where('room_id', $this->id)->whereNotIn('user_id', [Auth::user()->id])->first();
            return User::find($users->user_id)->status;
        }
    }

}
