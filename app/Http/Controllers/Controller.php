<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Room;
use App\Models\User;
use App\Models\Vote;
use App\Notifications\NewBadgeReceived;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use QCod\Gamify\Badge;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public  function profile(User $user){
//        ray(Comment::query()->first()->question->comments()->get());
        $oldBadges = $user->badges;
        $user->syncBadges();
        $newBadges = $user->badges()->get()->diff($oldBadges);
        ray($newBadges , $oldBadges,$user->badges);
        foreach($newBadges as $badge){
            $user->notify(new NewBadgeReceived($badge->name));
        }
        return User::query()
            ->where('users.id','=',$user->id)
            ->with('badges')
            ->withCount('comments')
            ->withCount('questions')
            ->withCount('rooms')
            ->withCount('validComments')
            ->withCount('ownedRooms')
            ->first();
    }

    public function badgesList(){
        return Badge::all();
    }

    public function updateInformation(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
        ]);
        Auth::user()->update($validated);
        return true ;
    }

    public function updatePassword(Request $request){
        $validated = $request->validate([
            'password' => 'required|string|min:6',
            'newPassword' => 'required|string|min:6',
        ]);
        ray(Hash::make($validated['password']), auth()->user()->password ,Hash::check($validated['password'] ,auth()->user()->password) );
        if(Hash::check($validated['password'] ,auth()->user()->password) ) {
            Auth::user()->update(['password'=>Hash::make($validated['newPassword'])]);
            return  Auth::user()->createToken('tokens')->plainTextToken;
        }
        return false;
    }

    public function updatePoints()
    {
        return Auth::user()->getPoints(true);
    }

    public function getGlobalLeaderBoard()
    {
        return User::query()->orderByDesc('reputation')->where('users.type',User::$Student)->paginate(20);
    }


    public function test(){
        return Vote::all();
    }
}
