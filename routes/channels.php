<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\MessageRoom;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('chat', function ($user) {
    return $user;
});

Broadcast::channel('{id}', function ($user, $room) {
    $data_room = MessageRoom::with('dataMember')->where('channel', $room)->first();

    foreach($data_room->dataMember as $i){
        if($i->user_id == $user->id){
            return true;
        }
    }

    return false;
});
