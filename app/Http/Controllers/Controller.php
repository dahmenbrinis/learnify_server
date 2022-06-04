<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public  function  profile(User $user){
        ray(User::find($user->id)->with('badges'));
        return User::find($user->id)->with('badges')->get() ;
    }

    public function updatePoints()
    {
        return Auth::user()->getPoints(true);
    }

    public function getGlobalLeaderBoard()
    {
        return User::query()->orderByDesc('reputation')->paginate(20);
    }


    public function test(){
        return Vote::all();
    }
}
