<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddVoteRequest;
use App\Http\Requests\RemoveVoteRequest;
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
        return Auth::user()->votes()->create($request->validated());
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
        return Auth::user()->votes()->where($request->validated())->delete();
    }

}
