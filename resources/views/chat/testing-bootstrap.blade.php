<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat App</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .chat-sidebar {
            height: 100vh;
            border-right: 1px solid #dee2e6;
        }
        .chat-messages {
            height: calc(100vh - 120px);
            overflow-y: auto;
        }
        .chat-input {
            border-top: 1px solid #dee2e6;
            padding: 1rem;
            background: white;
        }
        .chat-header {
            height: 60px;
            border-bottom: 1px solid #dee2e6;
        }
        .chat-list-item {
            cursor: pointer;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #dee2e6;
        }
        .chat-list-item:hover {
            background-color: #f8f9fa;
        }
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Left Sidebar -->
            <div class="col-md-3 chat-sidebar">
                <div class="p-3 chat-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Chats</h5>
                    <div>
                        <button class="btn btn-light"><i class="bi bi-pencil-square"></i></button>
                        <button class="btn btn-light"><i class="bi bi-three-dots"></i></button>
                    </div>
                </div>
                <div class="p-2">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search or start a new chat">
                    </div>
                </div>
                <div class="chat-list">
                    <div class="chat-list-item d-flex align-items-center">
                        <div class="avatar me-3">
                            <i class="bi bi-person"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Keuangan Cr Manufacture</h6>
                            <small class="text-muted">Last message...</small>
                        </div>
                        <div class="text-muted">
                            <small>21:55</small>
                        </div>
                    </div>
                    <!-- More chat items -->
                </div>
            </div>

            <!-- Right Chat Area -->
            <div class="col-md-9">
                <div class="chat-header d-flex align-items-center px-3">
                    <div class="avatar me-3">
                        <i class="bi bi-person"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0">Fauzan IT</h6>
                    </div>
                    <div>
                        <button class="btn btn-light"><i class="bi bi-camera-video"></i></button>
                        <button class="btn btn-light"><i class="bi bi-telephone"></i></button>
                        <button class="btn btn-light"><i class="bi bi-search"></i></button>
                    </div>
                </div>
                
                <div class="chat-messages p-3">
                    <!-- Messages will go here -->
                    <div class="d-flex justify-content-end mb-3">
                        <div class="bg-primary text-white rounded p-2">
                            ditutup menune?
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="bg-light rounded p-2">
                            hooh tutup sek wae
                        </div>
                    </div>
                </div>

                <div class="chat-input">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-light me-2"><i class="bi bi-emoji-smile"></i></button>
                        <button class="btn btn-light me-2"><i class="bi bi-paperclip"></i></button>
                        <input type="text" class="form-control me-2" placeholder="Type a message">
                        <button class="btn btn-light"><i class="bi bi-mic"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
