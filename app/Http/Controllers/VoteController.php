<?php

namespace App\Http\Controllers;

use App\Gamify\Points\QuestionCreated;
use App\Gamify\Points\VoteAdded;
use App\Http\Requests\AddVoteRequest;
use App\Http\Requests\RemoveVoteRequest;
use App\Models\Room;
use App\Models\Vote;
use Auth;
use Illuminate\Http\Response;

class VoteController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param AddVoteRequest $request
     * @return Response
     */
    public function vote(AddVoteRequest $request)
    {
        if(Auth::user()->votes()->where($request->except('room'))->doesntExist()){
            givePoint(new VoteAdded(Room::find($request['room'])));
            return Auth::user()->votes()->create($request->validated());
        }
        return null ;
    }

    /**
     * Remove the specified resource in storage.
     *
     * @param RemoveVoteRequest $request
     * @param Vote $vote
     * @return bool
     */
    public function unVote(RemoveVoteRequest $request)
    {

        if(Auth::user()->votes()->where($request->except('room'))->exists()){
            undoPoint(new VoteAdded(Room::find($request['room'])));
        }
        return Auth::user()->votes()->where($request->except('room'))->delete();
    }

}
