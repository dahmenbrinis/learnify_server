<?php

namespace App\Policies;

use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class RoomPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can ask a question.
     *
     * @param User $user
     * @param Room $room
     * @return Response|bool
     */
    public function ask(User $user, Room $room)
    {
        return  $user->can('view',$room);
    }

    public function join(User $user, Room $room)
    {
        return  $user->cannot('view',$room);
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function viewAny(User $user):bool
    {
        return true ;
    }


    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Room $room
     * @return bool
     */
    public function view(User $user, Room $room): bool
    {
        return  $user->rooms->contains($room);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user)
    {
        return $user->type === User::$Teacher;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Room $room
     * @return Response|bool
     */
    public function update(User $user, Room $room)
    {
        return $user->type === User::$Teacher && $room->creator->is($user);
    }

    public function dailyReputation(User $user , Room $room , string $actionName): bool
    {
        return $room->reputations()
            ->where('payee_id',$user->id)
            ->where('name',$actionName)
            ->whereDate('created_at', Carbon::today())
            ->doesntExist();
    }
    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Room $room
     * @return Response|bool
     */
    public function delete(User $user, Room $room)
    {
        return $user->type === User::$Teacher && $room->creator->is($user);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Room $room
     * @return Response|bool
     */
    public function restore(User $user, Room $room)
    {
        return $user->type === User::$Teacher && $room->creator->is($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Room $room
     * @return Response|bool
     */
    public function forceDelete(User $user, Room $room)
    {
        return $user->type === User::$Teacher && $room->creator->is($user);
    }
}
