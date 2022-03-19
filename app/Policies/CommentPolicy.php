<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Question;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Comment $comment
     * @return Response|bool
     */
    public function update(User $user, Comment $comment)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Comment $comment
     * @return Response|bool
     */
    public function delete(User $user, Comment $comment)
    {
        //
    }

    /**
     * Determine whether the user can approve(validate) the comment.
     *
     * @param User $user
     * @param Comment $comment
     * @return Response|bool
     */
    public function approve(User $user, Comment $comment , Question $question)
    {
        if($comment->isValid) return  false ;
        if($user->type != User::$Teacher) return  false ;
        if($user->id != $question->room->creator->id) return  false ;
        return true ;
    }

    /**
     * Determine whether the user can disApprove(unValidate) the comment.
     *
     * @param User $user
     * @param Comment $comment
     * @return Response|bool
     */
    public function disApprove(User $user, Comment $comment,Question $question)
    {
        return !$this->approve($user,$comment,$question);
    }





}
