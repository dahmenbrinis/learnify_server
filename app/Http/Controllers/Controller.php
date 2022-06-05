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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public  function profile(User $user){
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

    public function updateInformation(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
        ]);
        ray($validated);
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
            ray('password updated successfully');
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
        return User::query()->orderByDesc('reputation')->paginate(20);
    }


    public function test(){
        return Vote::all();
    }
}
