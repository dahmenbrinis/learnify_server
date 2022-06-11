<?php

namespace App\Http\Controllers;

use App\Gamify\Points\QuestionCreated;
use App\Gamify\Points\VoteAdded;
use App\Http\Requests\AddVoteRequest;
use App\Http\Requests\RemoveVoteRequest;
use App\Models\Comment;
use App\Models\Question;
use App\Models\Room;
use App\Models\Vote;
use App\Notifications\CommentVoted;
use App\Notifications\QuestionVoted;
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
            $vote = Auth::user()->votes()->create($request->validated());
            if($vote->votable_type == Comment::class ){
                $vote->votable->user->notify(new CommentVoted($vote->votable));
            }
            if($vote->votable_type == Question::class ){
                $vote->votable->user->notify(new QuestionVoted($vote->votable));
            }
            givePoint(new VoteAdded(Room::find($request['room']),$vote));
            return $vote;
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
        $voteQuery = Auth::user()->votes()->where($request->except('room')) ;
        if($voteQuery->exists()){
            $vote = $voteQuery->first();
            undoPoint(new VoteAdded(Room::find($request['room']),$vote));
        }
        return $voteQuery->delete();
    }

}
