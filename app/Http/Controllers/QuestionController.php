<?php

namespace App\Http\Controllers;

use App\Gamify\Points\QuestionCreated;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Question;
use App\Models\Room;
use App\Notifications\QuestionAdded;
use Auth;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return LengthAwarePaginator
     */
    public function index(Room $room)
    {
        ray($room->questions()->with('user')->paginate(12));
        return $room->questions()->with('user')->paginate(12);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreQuestionRequest $request
     * @param Room $room
     * @return Response
     */
    public function store(StoreQuestionRequest $request,Room $room)
    {
        $question =  Question::create($request->validated()+['user_id'=>auth()->id(),'room_id'=>$room->id]);
        givePoint(new QuestionCreated($room));
        Notification::send($room->users, new QuestionAdded($question));
        return $question ;
    }
    /**
     * Display the specified resource.
     *
     * @param Question $question
     * @return Response
     */
    public function myQuestions()
    {
        ray()->models(Auth::user()->questions()->with('user')->paginate(12));
        return Auth::user()->questions()->with('user')->paginate(12);
    }

    /**
     * Display the specified resource.
     *
     * @param Question $question
     * @return Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateQuestionRequest $request
     * @param Question $question
     * @return Response
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Question $question
     * @return Response
     */
    public function destroy(Question $question)
    {
        //
    }
}
