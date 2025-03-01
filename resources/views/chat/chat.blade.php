<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>CodePen - Material Messaging App Concept</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Montserrat'>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css'>
<link rel="stylesheet" href="{{asset('css/chat.css')}}">

</head>
<body>
<!-- partial:index.partial.html -->
<body>
  <div class="container">
    <div class="row">
      <nav class="menu">
        <ul class="items">
          <li class="item">
            <a href="{{url('/home')}}" style="color: white;">
                <i class="fa fa-home" aria-hidden="true"></i>
            </a>
          </li>
          <li class="item">
            <i class="fa fa-user" aria-hidden="true"></i>
          </li>
          <li class="item">
            <i class="fa fa-pencil" aria-hidden="true"></i>
          </li>
          <li class="item item-active">
            <i class="fa fa-commenting" aria-hidden="true"></i>
          </li>
          <li class="item">
            <i class="fa fa-file" aria-hidden="true"></i>
          </li>
          <li class="item">
            <i class="fa fa-cog" aria-hidden="true"></i>
          </li>
        </ul>
      </nav>

      <section class="discussions">
        <div class="discussion search">
          <div class="searchbar">
            <i class="fa fa-search" aria-hidden="true"></i>
            <input type="text" placeholder="Search..."></input>
          </div>
        </div>
        <div id="dataRoom"></div>
      </section>
      <section class="chat">
        <div id="refresh_data">
        </div>
        <div class="footer-chat" id="footer_chat">
          <input type="nummber" id="room_id" value="" hidden>
          <i class="icon fa fa-smile-o clickable" style="font-size:25pt;" aria-hidden="true"></i>
          <input type="text" class="write-message" id="written_message" placeholder="Type your message here"></input>
          <i class="icon send fa fa-paper-plane-o clickable" id="send_message"></i>
        </div>
      </section>
    </div>
  </div>
</body>
<!-- partial -->
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/collect.js/4.25.0/collect.js"></script>
<script src="/js/app.js"></script>
<script>
  $(document).ready(function(){


      $('#footer_chat').hide()
      var channelActive = ''
      var dataRoom = {}
      var dataChannel = []
      var dataUser = []

      function getRoom(){
        url = "{{url('/get_data_room')}}"
        token = "{{csrf_token()}}"

        $.ajax({
            url : url,
            method : 'GET',
            async : false,
            success : function(data){
              $.each(data.user, function(i,val){
                  dataUser[val.user_id] = val
              })
              $.each(data.channel, function(i, val){
                  dataRoom[val.channel] = val
                  dataChannel.push(val.channel)
              })
            },
            error : function(data){
                console.log(data)
            }
        })

      }

      function fetchDataRoom(dataRoom){
        var data = ''
        $.each(dataRoom, function(i,v){
          // var classList = v.channel == channelActive ? 'discussion message-active' : 'discussion'
          console.log({
            channel : v.channel,
            channelActive : channelActive
          })
          var ch_active = v.channel == channelActive ? 'message-active' : ''
          var status = v.type == 1 && v.status == 'online' ? '<div class="online"></div>' : ''
          if(v.data_chat.length != 0){
            data += `
              <div id="${v.channel}" class="discussion" >
                <div class="photo" style="background-image: url(https://images.unsplash.com/photo-1435348773030-a1d74f568bc2?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1050&q=80);">
                  ${status}
                </div>
                <div class="desc-contact">
                  <p class="name">${v.channel_name}</p>
                  <p class="message">${v.data_chat[0].message}</p>
                </div>
                <div class="timer">${v.data_chat[0].send_time}</div>
              </div>
            `
          }
        })
        $('#dataRoom').html(data)
      }

      function getMessage(dataCh){
        var data = ''
            data += `
              <div class="parent-header">
                <div class="header-chat">
                  <i class="icon fa fa-user-o" aria-hidden="true"></i>
                  <p class="name">${dataCh.channel_name}</p>
                  <i class="icon clickable fa fa-ellipsis-h right" aria-hidden="true"></i>
                </div>
                <div id="typingChat"></div>
              </div>
            `

        var chat = '<div class="messages-chat" id="message_chat">';
        for(var i = dataCh.data_chat.length - 1 ; i >= 0; i--){
            var auth_user = '{{Auth::user()->id}}'
            if(auth_user == dataCh.data_chat[i].user_id){
              chat += `
                <div class="message text-only">
                  <div class="response">
                    <p class="text">${dataCh.data_chat[i].message}</p>
                  </div>
                </div>
              `
            }else{
              chat += `
              <div class="message">
                <div class="photo" style="background-image: url(https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1050&q=80);">
                  <div class="online"></div>
                </div>
                <p class="text">${dataCh.data_chat[i].message}</p>
              </div>
              `
            }
        }
        chat += '</div>'

        data += chat

        $('#refresh_data').html(data)

      }

      getRoom()
      fetchDataRoom(dataRoom)
      

      const obj = Object.assign([], dataUser)


      Echo.join('chat') 
        .here((users) => {
            $.each(users,function(i, v){
              // console.log(v)
                // var user = dataUser[v.id]
                // console.log(user)
                // dataRoom[user.channel].status = 'online'
                // fetchDataRoom(dataRoom)
            })
        })

      Echo.join('chat')
      .joining((dataUser) => {
          url = "{{url('/set_online_user')}}"
          token = "{{csrf_token()}}"
          formData = {
              '_token' : token,
              'user_id' : dataUser.id
          }

          $.ajax({
              url : url,
              method : 'POST',
              data : formData,
              error : function(data){
                  console.log(data)
                  alert(data)
              }
          })
      })
      .leaving((dataUser) => {
          url = "{{url('/set_offline_user')}}"
          token = "{{csrf_token()}}"
          formData = {
              '_token' : token,
              'user_id' : dataUser.id
          }

          $.ajax({
              url : url,
              method : 'POST',
              data : formData,
              error : function(data){
                  console.log(data)
                  alert(data)
              }
          })
      })
      .listen('UserOnline', (e) => {
          
          // var user_login = '{{Auth::user()->id}}'
          // if(user_login != e.user.id){
          //   var user = dataUser[e.user.id]
          //   dataRoom[user.channel].status = e.user.status
          //   fetchDataRoom(dataRoom)
          // }  
      })
      .listen('UserOffline', (e) => {
          
          // var user_login = '{{Auth::user()->id}}'
          // if(user_login != e.user.id){
          //   var user = dataUser[e.user.id]
          //   dataRoom[user.channel].status = e.user.status
          //   fetchDataRoom(dataRoom)
          // }
      });

      $('#send_message').on('click', function(){
        var message = $('#written_message').val()
        var room_id = $('#room_id').val()

        if(message){
          url = "{{url('/send_message')}}"
          token = "{{csrf_token()}}"
          formData = {
              '_token' : token,
              'room_id' : room_id,
              'message' : message
          }

          $.ajax({
              url : url,
              method : 'POST',
              data : formData,
              success : function(data){
                $('#written_message').val('')
              },
              error : function(data){
                  console.log(data)
                  alert(data)
              }
          })
        }
      })

      $.each(dataChannel, function(i,v){
          $('#' + v).on('click', function(){
            channelActive = v
            var dataCh = dataRoom[v]
            
            getMessage(dataCh)
            
          $('#room_id').val(dataCh.id)
          $('#footer_chat').show()

          })
      })

      $.each(dataRoom, function(i,v){
          $('#written_message').keypress(function(){
              Echo.private(v.channel).whisper('typing', {
                user: '{{Auth::user()->id}}',
                typing: true
              })
          })

          Echo.private(v.channel)
          .listenForWhisper('typing', (e) => {
              $('#typingChat').html('typing...')
              setInterval(() => {
                $('#typingChat').html('')
              }, 2000);
          });

          Echo.private(v.channel).listen("SendMessage", (event) => {
            var dataCh = event.data.channel
            var dataMs = event.data.message
            var dataChat = dataRoom[dataCh.channel].data_chat

            dataChat.unshift(dataMs)
            $('#'+ dataCh.channel).html(`
                <div class="photo" style="background-image: url(https://images.unsplash.com/photo-1435348773030-a1d74f568bc2?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1050&q=80);">
                  <div class="online"></div>
                </div>
                <div class="desc-contact">
                  <p class="name">${dataRoom[dataCh.channel].channel_name}</p>
                  <p class="message">${dataRoom[dataCh.channel].data_chat[0].message}</p>
                </div>
                <div class="timer">${dataRoom[dataCh.channel].data_chat[0].send_time}</div>
            `)
            
            if(channelActive == dataCh.channel){
              getMessage(dataRoom[dataCh.channel])
            }

          });
      })
      
  })

    function getDataMessage(room_id){
      url = "{{url('/get_data_message')}}"
      token = "{{csrf_token()}}"
      formData = {
          '_token' : token,
          'room_id' : room_id
      }

      $.ajax({
          url : url,
          method : 'POST',
          data : formData,
          success : function(data){
             $('#refresh_data').html(data)
          },
          error : function(data){
              console.log(data)
          }
      })
    }

    function sendMessage(){
      var message = $('#written_message').val()
      var room_id = $('#room_id').val()

      if(message){
        url = "{{url('/send_message')}}"
        token = "{{csrf_token()}}"
        formData = {
            '_token' : token,
            'room_id' : room_id,
            'message' : message
        }

        $.ajax({
            url : url,
            method : 'POST',
            data : formData,
            success : function(data){
               $('#refresh_data').html(data)
            },
            error : function(data){
                console.log(data)
            },
            completed : function(){
                $('#written_message').val('')
            }
        })
      }

    }
</script>

</body>
</html>