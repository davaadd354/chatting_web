<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .online-badge {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 12px;
            height: 12px;
            background-color: #10B981;
            border-radius: 50%;
            border: 2px solid white;
        }
    </style>
</head>
<body class="h-screen bg-gray-100">
    <div class="flex h-full">
        <!-- Left Sidebar -->
        <div id="sidebar" class="w-full md:w-80 bg-white border-r md:block">
            <!-- Header -->
            <div class="p-4 border-b">
                <div class="flex items-center justify-between">
                    <h1 class="text-xl font-semibold">Chats</h1>
                    <div class="flex space-x-2">
                        <button class="p-2 hover:bg-gray-100 rounded-full">
                            <i class="fas fa-edit"></i>
                        </button>
                        </button>
                        <button class="p-2 hover:bg-gray-100 rounded-full hidden md:block">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                    </div>
                </div>
                <!-- Search -->
                <div class="mt-4 relative">
                    <input type="text" placeholder="Search or start a new chat" 
                           class="w-full px-4 py-2 bg-gray-100 rounded-lg focus:outline-none">
                    <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                </div>
            </div>
            
            <!-- Chat List -->
            <div class="overflow-y-auto h-[calc(100%-130px)]" id="list_room">
                
            </div>
        </div>

        <!-- Main Chat Area -->
        <div id="chatArea" class="hidden md:flex flex-1 flex-col">
            <!-- Chat Header -->
            <div class="h-16 border-b bg-white flex items-center justify-between px-4 hidden" id="header_chat">
                <div class="flex items-center">
                    <button class="md:hidden mr-2 p-2 hover:bg-gray-100 rounded-full" onclick="toggleChat()">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <div class="w-10 h-10 bg-gray-300 rounded-full flex-shrink-0 relative" id="room_header_img">
                        <img src="https://ui-avatars.com/api/?name=Fauzan+IT" class="rounded-full" alt="avatar">
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold" id="room_header_name"></h3>
                        <span class="text-green-500 text-sm" id="typing_chat"></span>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="p-2 hover:bg-gray-100 rounded-full hidden md:block">
                        <i class="fas fa-video"></i>
                    </button>
                    <button class="p-2 hover:bg-gray-100 rounded-full hidden md:block">
                        <i class="fas fa-phone"></i>
                    </button>
                    <button class="p-2 hover:bg-gray-100 rounded-full">
                        <i class="fas fa-search"></i>
                    </button>
                    <button class="p-2 hover:bg-gray-100 rounded-full md:hidden">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
            </div>

            <!-- Messages Area -->
            <div class="bg-gray-50 p-4 overflow-y-auto flex-1 hidden" id="message_chat">
               
            </div>

            <!-- Message Input -->
            <div class="bg-white p-4 border-t hidden" id="footer_chat">
                <input type="nummber" id="room_id" value="" hidden>
                <div class="flex items-center space-x-4">
                    <button class="p-2 hover:bg-gray-100 rounded-full hidden md:block">
                        <i class="far fa-smile"></i>
                    </button>
                    <button class="p-2 hover:bg-gray-100 rounded-full">
                        <i class="fas fa-paperclip"></i>
                    </button>
                    <input type="text" placeholder="Type a message" id="written_message"
                        class="flex-1 px-4 py-2 bg-gray-100 rounded-lg focus:outline-none">
                    <button class="p-2 hover:bg-gray-100 rounded-full" id="send_message">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/collect.js/4.25.0/collect.js"></script>
    <script src="/js/app.js"></script>
    <script>
        function toggleChat() {
            const sidebar = document.getElementById('sidebar');
            const chatArea = document.getElementById('chatArea');
            
            if (window.innerWidth < 768) { // mobile view
                if (chatArea.classList.contains('hidden')) {
                    sidebar.classList.add('hidden');
                    chatArea.classList.remove('hidden');
                    chatArea.classList.add('flex');
                } else {
                    sidebar.classList.remove('hidden');
                    chatArea.classList.add('hidden');
                    chatArea.classList.remove('flex');
                }
            }
        }

        $(document).ready(function(){
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

                // console.log({dataRoom : dataRoom})
                // console.log({dataChannel : dataChannel})
            }

            function fetchDataRoom(dataRoom){
                var data = ''
                $.each(dataRoom, function(i,v){
                    var status = v.type == 1 && v.status == 'online' ? '<div class="online"></div>' : ''
                    if(v.data_chat.length != 0){

                        data += `
                            <div id="${v.channel}" class="flex items-center p-4 hover:bg-gray-100 cursor-pointer" onclick="toggleChat()">
                                <div class="w-12 h-12 bg-gray-300 rounded-full flex-shrink-0 relative">
                                    <img src="https://ui-avatars.com/api/?name=${v.channel_name}" class="rounded-full" alt="avatar">
                                    <div id="tampil_status_${v.channel}" class="online-badge hidden"></div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="flex justify-between">
                                        <h3 class="font-semibold">${v.channel_name}</h3>
                                        <span class="text-sm text-gray-500">${v.data_chat[0].send_time}</span>
                                    </div>
                                    <p class="text-gray-600 text-sm truncate">${v.data_chat[0].message}</p>
                                </div>
                            </div>
                        `
                    }
                })

                $('#list_room').html(data)
            }

            function getMessage(dataCh){
                var status_online = 'hidden'
                if(dataRoom[dataCh.channel].status == 'online' && dataRoom[dataCh.channel].type == 1){
                    status_online = ''
                }
               // Replace header room chat
               $('#room_header_img').html(`
                    <img src="https://ui-avatars.com/api/?name=${dataCh.channel_name}" class="rounded-full" alt="avatar">
                    <div id="tampil_status_${dataCh.channel}" class="online-badge ${status_online}"></div>
               `)
               $('#room_header_name').html(dataCh.channel_name)

               // Replace list chat
                var chat = ''
                for(var i = dataCh.data_chat.length - 1 ; i >= 0; i--){
                    var auth_user = '{{Auth::user()->id}}'
                    if(auth_user == dataCh.data_chat[i].user_id){
                        chat += `
                            <div class="flex justify-end mb-4">
                                <div class="bg-green-100 rounded-lg p-3 max-w-[75%] md:max-w-md">
                                    <p>${dataCh.data_chat[i].message}</p>
                                    <span class="text-xs text-gray-500 block text-right">${dataCh.data_chat[i].send_hour}</span>
                                </div>
                            </div>
                        `
                    }else{
                        chat += `
                            <div class="flex mb-4">
                                <div class="bg-white rounded-lg p-3 max-w-[75%] md:max-w-md">
                                    <p>${dataCh.data_chat[i].message}</p>
                                    <span class="text-xs text-gray-500 block">${dataCh.data_chat[i].send_hour}</span>
                                </div>
                            </div>
                        `
                    }
                }

                $('#message_chat').html(chat)
            }

            getRoom()
            fetchDataRoom(dataRoom)

            const obj = Object.assign([], dataUser)

            Echo.join('chat') 
            .here((users) => {
                $.each(users,function(i, v){
                    var user = dataUser[v.id]
                    if(user && dataRoom[user.channel].type == 1){
                        $(`#tampil_status_${user.channel}`).removeClass('hidden')
                        dataRoom[user.channel].status = 'online'
                    }
                })
            })

            Echo.join('chat')
            .joining((user) => {
                var user_data = dataUser[user.id]
                if(user_data && dataRoom[user_data.channel].type == 1){
                    $(`#tampil_status_${user_data.channel}`).removeClass('hidden')
                    dataRoom[user.channel].status = 'online'
                }

                url = "{{url('/set_online_user')}}"
                token = "{{csrf_token()}}"
                formData = {
                    '_token' : token,
                    'user_id' : user.id
                }

                $.ajax({
                    url : url,
                    method : 'POST',
                    data : formData,
                    error : function(data){
                        console.log(data)
                    }
                })
            })
            .leaving((user) => {
                var user_data = dataUser[user.id]
                if(user_data && dataRoom[user_data.channel].type == 1){
                    $(`#tampil_status_${user_data.channel}`).addClass('hidden')
                    dataRoom[user.channel].status = 'offline'
                }

                url = "{{url('/set_offline_user')}}"
                token = "{{csrf_token()}}"
                formData = {
                    '_token' : token,
                    'user_id' : user.id
                }

                $.ajax({
                    url : url,
                    method : 'POST',
                    data : formData,
                    error : function(data){
                        console.log(data)
                    }
                })
            })

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
                    }
                })
                }
            })

            $.each(dataChannel, function(i,v){
                $('#' + v).on('click', function(){
                    $('#header_chat').removeClass('hidden')
                    $('#message_chat').removeClass('hidden')
                    $('#footer_chat').removeClass('hidden')
                    
                    channelActive = v
                    var dataCh = dataRoom[v]
                    
                    getMessage(dataCh)
                    
                    $('#room_id').val(dataCh.id)

                })
            })

            $.each(dataRoom, function(i,v){
                $('#written_message').keyup(function(){
                    Echo.private(v.channel).whisper('typing', {
                        user: '{{Auth::user()->id}}',
                        channel: v.channel,
                        typing: true
                    })
                })

                Echo.private(v.channel)
                .listenForWhisper('typing', (e) => {
                    var room_id = $('#room_id').val()
                    if(v.id == room_id){
                        $('#typing_chat').html('typing...')
                        setInterval(() => {
                            $('#typing_chat').html('')
                        }, 500);
                    }
                });

                Echo.private(v.channel).listen("SendMessage", (event) => {
                    var dataCh = event.data.channel
                    var dataMs = event.data.message
                    var dataChat = dataRoom[dataCh.channel].data_chat

                    dataChat.unshift(dataMs)
                    $('#'+ dataCh.channel).html(`
                        <div class="w-12 h-12 bg-gray-300 rounded-full flex-shrink-0">
                            <img src="https://ui-avatars.com/api/?name=${dataRoom[dataCh.channel].channel_name}" class="rounded-full" alt="avatar">
                        </div>
                        <div class="ml-4 flex-1">
                            <div class="flex justify-between">
                                <h3 class="font-semibold">${dataRoom[dataCh.channel].channel_name}</h3>
                                <span class="text-sm text-gray-500">${dataRoom[dataCh.channel].data_chat[0].send_time}</span>
                            </div>
                            <p class="text-gray-600 text-sm truncate">${dataRoom[dataCh.channel].data_chat[0].message}</p>
                        </div>
                    `)
                    
                    if(channelActive == dataCh.channel){
                        getMessage(dataRoom[dataCh.channel])
                    }

                });
            })
        })

    </script>
</body>
</html>
