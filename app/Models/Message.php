<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MessageRoom;
use App\Traits\DateTimeTrait;
use Carbon\Carbon;

class Message extends Model
{
    use HasFactory,DateTimeTrait;

    protected $appends = ['send_time', 'send_hour'];

    public function dataRoom(){
        return $this->belongsTo(MessageRoom::class, 'room_id', 'id');
    }

    public function getSendTimeAttribute(){
        
        return $this->getSendTime($this->created_at,date("Y-m-d H:i:s"));
        
    }

    public function getSendHourAttribute(){
        return Carbon::parse($this->created_at)->format('H:i');
    }
}
