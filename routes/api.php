<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\RoomController;
use App\Models\Room;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $room = Room::factory()->make()->first();
    $room->update(['creator_id'=>Auth::id()]);
    $room->refresh();
//    dd(Auth::user()->can('update',$room),$room->permissions );
    return Room::all();
});
Route::middleware('auth:sanctum')->group(function (){
    Route::apiResource('/room', RoomController::class);
    Route::post('/join_room/{room}',[RoomController::class,'join']);
});
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'register']);
//Route::post('/', [ImageController::class, 'getImage2']);
Route::get('/{file}', [ImageController::class, 'getImage']);
//Route::apiResource('/room', RoomController::class );

