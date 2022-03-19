<?php

namespace App\Http\Controllers;

use App\Gamify\Points\CommentApproved;
use App\Gamify\Points\CommentCreated;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Question;
use App\Models\User;
use App\Notifications\NewCommentNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Question $question)
    {
        $comment = $question->comments()
            ->make($request->validated())->user()
            ->associate(Auth::user());
        $comment->save();
        givePoint(new CommentCreated($question->room , Auth::user()));
        $question->user->notify(new NewCommentNotification($comment));
        return $comment;
    }

    public function index(Question $question)
    {
        return $question->comments()->with('user')->with('votes')->paginate(12);
    }


    public function approve(Question $question , Comment $comment)
    {
//        dd('test');
        if(Auth::user()->can('approve',[$comment,$question])){
            $comment->isValid = true;
            $comment->update();
            givePoint(new CommentApproved($question->room,$comment->user));
            return true;
        }
        return false ;
//        return response(['message'=>'error','error'=>'error'],301);
    }
    public function disApprove(Question $question , Comment $comment)
    {
        if(Auth::user()->can('disApprove',[$comment,$question])){
            $comment->isValid = false;
            $comment->update();
            undoPoint(new CommentApproved($question->room,$comment->user));
            return true;
        }
        return false ;
    }
}
