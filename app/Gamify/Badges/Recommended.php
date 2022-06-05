<?php

namespace App\Gamify\Badges;

use QCod\Gamify\BadgeType;

class Recommended extends BadgeType
{
    /**
     * Description for badge
     *
     * @var string
     */
    protected $description = 'This person is recommended by teachers';

    /**
     * Check is user qualifies for badge
     *
     * @param $user
     * @return bool
     */
    public function qualifier($user)
    {
        return $user->getPoints() >= 300000;
    }
}
