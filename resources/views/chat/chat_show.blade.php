
    <div class="header-chat">
      <i class="icon fa fa-user-o" aria-hidden="true"></i>
      <p class="name">{{$channel}}</p>
      <i class="icon clickable fa fa-ellipsis-h right" aria-hidden="true"></i>
    </div>
    <div class="messages-chat">
      @foreach($messages as $m)
        @if(Auth::user()->id != $m->user_id)
          <div class="message">
            <div class="photo" style="background-image: url(https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1050&q=80);">
              <div class="online"></div>
            </div>
            <p class="text">{{$m->message}}</p>
          </div>
          {{-- <p class="time">{{$m->send_time}}</p> --}}
        @else
          <div class="message text-only">
            <div class="response">
              <p class="text">{{$m->message}}</p>
            </div>
          </div>
          {{-- <p class="response-time time">{{$m->send_time}}</p> --}}
        @endif
      @endforeach
    </div>
    <div class="footer-chat">
      <input type="nummber" id="room_id" value="{{$messages[0]->room_id}}" hidden>
      <i class="icon fa fa-smile-o clickable" style="font-size:25pt;" aria-hidden="true"></i>
      <input type="text" class="write-message" id="written_message" placeholder="Type your message here"></input>
      <i class="icon send fa fa-paper-plane-o clickable" id="send_message"></i>
    </div>