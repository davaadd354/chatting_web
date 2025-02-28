<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
                        <button class="p-2 hover:bg-gray-100 rounded-full md:hidden" onclick="toggleChat()">
                            <i class="fas fa-times"></i>
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
            <div class="overflow-y-auto h-[calc(100%-130px)]">
                <!-- Chat Item -->
                <div class="flex items-center p-4 hover:bg-gray-100 cursor-pointer" onclick="toggleChat()">
                    <div class="w-12 h-12 bg-gray-300 rounded-full flex-shrink-0">
                        <img src="https://ui-avatars.com/api/?name=IT+Staff" class="rounded-full" alt="avatar">
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="flex justify-between">
                            <h3 class="font-semibold">IT System Staff</h3>
                            <span class="text-sm text-gray-500">21:44</span>
                        </div>
                        <p class="text-gray-600 text-sm truncate">tak cek bisa om</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Chat Area -->
        <div id="chatArea" class="hidden md:flex flex-1 flex-col">
            <!-- Chat Header -->
            <div class="h-16 border-b bg-white flex items-center justify-between px-4">
                <div class="flex items-center">
                    <button class="md:hidden mr-2 p-2 hover:bg-gray-100 rounded-full" onclick="toggleChat()">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <div class="w-10 h-10 bg-gray-300 rounded-full">
                        <img src="https://ui-avatars.com/api/?name=Fauzan+IT" class="rounded-full" alt="avatar">
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold">Fauzan IT</h3>
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
            <div class="flex-1 bg-gray-50 p-4 overflow-y-auto">
                <!-- Message bubbles -->
                <div class="flex justify-end mb-4">
                    <div class="bg-green-100 rounded-lg p-3 max-w-[75%] md:max-w-md">
                        <p>ditutup menune?</p>
                        <span class="text-xs text-gray-500 block text-right">18:37</span>
                    </div>
                </div>
                <div class="flex mb-4">
                    <div class="bg-white rounded-lg p-3 max-w-[75%] md:max-w-md">
                        <p>hooh tutup sek wae</p>
                        <span class="text-xs text-gray-500 block">18:37</span>
                    </div>
                </div>
            </div>

            <!-- Message Input -->
            <div class="bg-white p-4 border-t">
                <div class="flex items-center space-x-4">
                    <button class="p-2 hover:bg-gray-100 rounded-full hidden md:block">
                        <i class="far fa-smile"></i>
                    </button>
                    <button class="p-2 hover:bg-gray-100 rounded-full">
                        <i class="fas fa-paperclip"></i>
                    </button>
                    <input type="text" placeholder="Type a message" 
                           class="flex-1 px-4 py-2 bg-gray-100 rounded-lg focus:outline-none">
                    <button class="p-2 hover:bg-gray-100 rounded-full">
                        <i class="fas fa-microphone"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

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
    </script>
</body>
</html>
