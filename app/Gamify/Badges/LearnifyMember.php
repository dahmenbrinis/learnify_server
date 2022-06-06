<?php

namespace App\Gamify\Badges;

use QCod\Gamify\BadgeType;

class LearnifyMember extends BadgeType
{
    /**
     * Description for badge
     *
     * @var string
     */
    protected $description = 'create account on learnify';
    protected $name = 'Learnify Member';
    protected $level = 1;
    /**
     * Check is user qualifies for badge
     *
     * @param $user
     * @return bool
     */
    public function qualifier($user)
    {
        return $user->getPoints() >= 0;
    }
}
