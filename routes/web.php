<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\RoomController;
use App\Models\Question;
use App\Models\User;
use App\Notifications\QuestionAdded;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;

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
//Route::get('/{file}', [ImageController::class, 'getImage']);
//Route::get('/', function (){
////    return \App\Models\Image::all();
////    dd(User::all()->first());
//    Notification::send(User::all(), new QuestionAdded(Question::all()->first()));
//    return 'default route';
//});
//Route::post('/api/register', [AuthController::class, 'register']);
//Route::apiResource('/room', RoomController::class );
