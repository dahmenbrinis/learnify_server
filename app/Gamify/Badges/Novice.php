<?php

namespace App\Gamify\Badges;

use QCod\Gamify\BadgeType;

class Novice extends BadgeType
{
    /**
     * Description for badge
     *
     * @var string
     */
    protected $description = 'answer more than 3 questions';
    protected $name = 'Novice';
    protected $level = 1;
    /**
     * Check is user qualifies for badge
     *
     * @param $user
     * @return bool
     */
    public function qualifier($user)
    {
        return $user->questions()->count()>3;
    }
}
