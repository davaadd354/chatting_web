<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Events\UserOnline;
use App\Events\UserOffline;


class UserController extends Controller
{
    public function set_online_user(Request $request){
        $user_id = $request->user_id;
        $user = User::find($user_id);

        $user->status = 'online';

        $user->save();

        UserOnline::dispatch($user);
    }

    public function set_offline_user(Request $request){
        $user_id = $request->user_id;
        $user = User::find($user_id);

        $user->status = 'offline';

        $user->save();

        UserOffline::dispatch($user);
    }
}
