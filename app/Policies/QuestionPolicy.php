<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\Room;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class QuestionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @param Room $room
     * @return Response|bool
     */
    public function viewAny(User $user,Room $room)
    {
        return  $user->can('view',$room);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Question $question
     * @param Room $room
     * @return bool
     */
    public function view(User $user, Question $question, Room $room): bool
    {
        return $user->can('view', $room);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @param Room $room
     * @return Response|bool
     */
    public function create(User $user ,Room $room)
    {
        return  $user->can('ask',$room);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Question $question
     * @param Room $room
     * @return bool
     */
    public function update(User $user, Question $question, Room $room): bool
    {
        return $user->questions->contains($question);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Question $question
     * @param Room $room
     * @return bool
     */
    public function delete(User $user, Question $question, Room $room): bool
    {
        return $user->questions->contains($question);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Question $question
     * @param Room $room
     * @return bool
     */
    public function restore(User $user, Question $question, Room $room): bool
    {
        return $user->questions->contains($question);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Question $question
     * @param Room $room
     * @return Response|bool
     */
    public function forceDelete(User $user, Question $question, Room $room): bool
    {
        return $user->questions->contains($question);
    }
}
