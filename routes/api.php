<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/rooms', RoomController::class);
    Route::post('/update_rooms/{room}', [RoomController::class,'update']);
    Route::post('/join_room/{room}', [RoomController::class, 'join']);
    Route::post('/leave_room/{room}', [RoomController::class, 'leave']);
    Route::get('/rooms/{room}/kick/{user}', [RoomController::class, 'kick']);
    Route::get('/rooms/{room}/commend/{user}', [RoomController::class, 'commend']);
    Route::get('/room_leaderboard/{room}', [RoomController::class, 'leaderboard']);
    Route::get('/room_management/{room}', [RoomController::class, 'management']);
    Route::apiResource('/rooms/{room}/questions', QuestionController::class);
    Route::get('/my_questions', [QuestionController::class, 'myQuestions']);
    Route::get('questions/{question}/comments', [CommentController::class, 'index']);
    Route::get('questions/{question}/comments/{comment}/approve', [CommentController::class, 'approve']);
    Route::get('questions/{question}/comments/{comment}/disApprove', [CommentController::class, 'disApprove']);
    Route::post('questions/{question}/comments', [CommentController::class, 'store']);
    Route::post('/images', [ImageController::class, 'store']);
    Route::post('/fcm_update', [AuthController::class, 'updateFcmToken']);
    Route::get('/updatePoints',[Controller::class,'updatePoints']);
//    Route::get('/profile/{user}',[Controller::class,'profile']);
//    Route::get('/badgesList',[Controller::class,'badgesList']);
    Route::post('/profile',[Controller::class,'updateInformation']);
    Route::post('/updatePassword',[Controller::class,'updatePassword']);
    Route::get('/test', [Controller::class, 'test']);
    Route::post('/vote',[VoteController::class , 'vote']);
    Route::post('/unVote',[VoteController::class , 'unVote']);
    Route::post('/logout', [AuthController::class, 'signout']);
/// for notifications
    Route::get('/notification/count',[NotificationController::class,'count']);
    Route::get('/notification/index',[NotificationController::class,'index']);
    Route::post('/notification/mark_read',[NotificationController::class,'markRead']);
});
Route::get('/profile/{user}',[Controller::class,'profile']);
Route::get('/badgesList',[Controller::class,'badgesList']);
Route::get('/leaderboard',[Controller::class,'getGlobalLeaderBoard']);
Route::get('/images/{image}/{alt}', [ImageController::class, 'view']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

