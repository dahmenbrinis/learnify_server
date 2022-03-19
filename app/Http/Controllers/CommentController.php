<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Question;
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
        $question->user->notify(new NewCommentNotification($comment));
        return $comment;
    }

    public function index(Question $question)
    {
        return $question->comments()->with('user')->with('votes')->paginate(12);
    }
}
