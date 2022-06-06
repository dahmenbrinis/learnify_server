<?php

namespace App\Gamify\Badges;

use App\Models\User;
use QCod\Gamify\BadgeType;

class Champion extends BadgeType
{
    /**
     * Description for badge
     *
     * @var string
     */
    protected $description = 'reach rank 3 in global leaderboard';
    protected $name = 'Champion';
    protected $level = 4;
    /**
     * Check is user qualifies for badge
     *
     * @param $user
     * @return bool
     */
    public function qualifier($user)
    {
        $champions = User::query()->orderByDesc('reputation')->limit(3)->get();
        return $champions->where('id','=',$user->id)->count()>0;
    }
}
