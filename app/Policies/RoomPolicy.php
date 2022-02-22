<?php

namespace App\Policies;

use App\Models\Room;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoomPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can ask a question.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function askQuestion(User $user, Room $room)
    {
        if(!$user) return  false ;
        return  true ;
    }

    public function join(User $user, Room $room)
    {
        if(!$user) return  false ;
        return  $user->cannot('view',$room);
    }
    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        if(!$user) return  false ;
        return true ;
    }


    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Room  $room
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function view(User $user, Room $room)
    {
        if(!$user) return  false ;
        return  $user->rooms->contains($room);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        if(!$user) return  false ;
        return $user->type === User::$Teacher;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Room $room)
    {
        if(!$user) return  false ;
        return $user->type === User::$Teacher && $room->creator->is($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Room $room)
    {
        if(!$user) return  false ;
        return $user->type === User::$Teacher && $room->creator->is($user);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Room $room)
    {
        if(!$user) return  false ;
        return $user->type === User::$Teacher && $room->creator->is($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Room $room)
    {
        if(!$user) return  false ;
        return $user->type === User::$Teacher && $room->creator->is($user);
    }
}
