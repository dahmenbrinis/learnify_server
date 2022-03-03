<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vote;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class VotePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user, $model)
    {
        return true;
//        return $model->votes()->where('user_id',$user)->doesntExist();
    }


    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Vote $vote
     * @return Response|bool
     */
    public function delete(User $user, Vote $vote)
    {
        return $vote->user->is($user);
    }
}
