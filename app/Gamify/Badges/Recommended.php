<?php

namespace App\Gamify\Badges;

use App\Models\User;
use QCod\Gamify\BadgeType;

class Recommended extends BadgeType
{
    /**
     * Description for badge
     *
     * @var string
     */
    protected $description = 'get 5 recommendation from teachers';
    protected $level = 2;
    /**
     * Check is user qualifies for badge
     *
     * @param $user
     * @return bool
     */
    public function qualifier($user)
    {
        return $user->studentCommendation()->count()>5;
    }
}
