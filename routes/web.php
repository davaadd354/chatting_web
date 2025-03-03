<?php

use Illuminate\Support\Facades\Route;
use App\Events\TestingEvent;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/chat', [ChatController::class, 'index'])->name('chat');
// Route::get('/chat_testing', [ChatController::class, 'chat_testing'])->name('chat_testing');
Route::post('/get_data_message', [ChatController::class, 'get_data_message'])->name('get_data_message');
Route::post('/send_message', [ChatController::class, 'send_message'])->name('send_message'); 
Route::get('/get_data_room', [ChatController::class, 'get_data_room'])->name('get_data_room');  
Route::post('/set_online_user', [UserController::class, 'set_online_user'])->name('set_online_user');
Route::post('/set_offline_user', [UserController::class, 'set_offline_user'])->name('set_offline_user');