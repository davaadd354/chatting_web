<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\MessageRoom;
use App\Models\Message;
use App\Models\RoomMember;
use App\Events\SendMessage;


class ChatController extends Controller
{
    public function index(){

        return view('chat.chat');
    }

    public function chat_testing(){
        return view('chat.testing-bootstrap');
    }

    public function get_data_message(Request $request, Message $message){
        $messages = $message->leftJoin('users as b', 'messages.user_id', 'b.id')
                            ->select(
                                'messages.*',
                                'b.name'
                            )
                            ->where('room_id', $request->room_id)
                            ->orderBy('messages.id')
                            ->get();
       
        $channel = MessageRoom::find($request->room_id);

        $data = [
            'channel' => $channel->channel_name,
            'messages' => $messages
        ];

        return view('chat.chat_show', $data);
    }

    public function send_message(Request $request){
        $room_id = $request->room_id;
        $message = $request->message;
        $user_id = Auth::user()->id;

        $data_user = RoomMember::where('room_id', $room_id)->get();

        if(count($data_user) > 0){
            $cek_user = false;
            foreach($data_user as $i){
                if($user_id == $i->user_id){
                    $cek_user = true;
                }
            }

            if($cek_user){
               $data_id =  DB::table('messages')->insertGetId([
                    'room_id' => $room_id,
                    'user_id' => $user_id,
                    'message' => $message
                ]);

                $dataInsert = Message::find($data_id);

                $channel = MessageRoom::find($request->room_id);

                $dataInsert = [
                    'channel' => $channel,
                    'message' => $dataInsert
                ];

                SendMessage::dispatch($dataInsert);

                // $messages = Message::leftJoin('users as b', 'messages.user_id', 'b.id')
                //                     ->select(
                //                         'messages.*',
                //                         'b.name'
                //                     )
                //                     ->where('room_id', $request->room_id)->get();

                // $data = [
                //     'channel' => $channel->channel_name,
                //     'messages' => $messages
                // ];

                // return view('chat.chat_show', $data);

                return response()->json('success');

            }

        }
        
        
        return response()->json('data tidak valid', 400);
        

    }

    public function get_data_room(){
        $user_id = Auth::user()->id;

        $channel = MessageRoom::with([
            'dataChat' => function($q){
                $q->orderBy('id','desc');
            }])
            ->leftJoin('room_members as b', 'message_rooms.id', 'b.room_id')
            ->select(
                'message_rooms.*'
            )
            ->where('b.user_id', $user_id)
            ->get();

        $rooms = RoomMember::where('user_id', $user_id)->get();
        $arr_room = [];
        foreach($rooms as $i){
            array_push($arr_room, $i->room_id);
        }

        $data_user = DB::table('room_members as a')
                        ->leftJoin('users as b', 'a.user_id', 'b.id')
                        ->leftJoin('message_rooms as c', 'a.room_id', 'c.id')
                        ->select(
                            'a.user_id',
                            'c.channel',
                            'b.status'
                        )
                        ->whereIn('a.room_id', $arr_room)
                        ->where('a.user_id', '!=', $user_id)
                        ->get();

        $user = Auth::user();

        $data = [
            'user' => $data_user,
            'channel' => $channel
        ];

        return response()->json($data);
    }

}
