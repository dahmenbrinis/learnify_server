<?php

namespace App\Policies;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReputationPolicy
{
    use HandlesAuthorization;
    public function dailyReputation(User $user , string $actionName){
        return $user->reputations()
            ->where('name',$actionName)
            ->whereDate('created_at', Carbon::today())
            ->doesntExist();
    }
}
