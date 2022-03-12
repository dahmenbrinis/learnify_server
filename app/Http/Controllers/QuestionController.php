<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Question;
use App\Models\Room;
use App\Notifications\QuestionAdded;
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
//        dd('test');
//        Notification::send($room->users,new QuestionAdded($question));
//        $room->update(['name'=>'changed']);
        Notification::send($room->users, new QuestionAdded($question));
        return $question ;
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
