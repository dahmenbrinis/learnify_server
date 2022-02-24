<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Question $question)
    {
        $comment = $question->comments()
            ->make($request->validated())->user()
            ->associate(Auth::user());
        $comment->save();
        return $comment;
    }

    public function index(Question $question)
    {
        return $question->comments()->with('user')->paginate(12);
    }
}
