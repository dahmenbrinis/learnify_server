<?php

namespace App\Gamify\Badges;

use QCod\Gamify\BadgeType;

class Curiosity extends BadgeType
{
    /**
     * Description for badge
     *
     * @var string
     */
    protected $description = 'ask 10 questions';
    protected $name = 'Curiosity';
    protected $level = 1;
    /**
     * Check is user qualifies for badge
     *
     * @param $user
     * @return bool
     */
    public function qualifier($user)
    {
        return $user->questions()->count()>=10;
    }
}
