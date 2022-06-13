<?php

namespace App\Gamify\Badges;

use QCod\Gamify\BadgeType;

class Expert extends BadgeType
{
    /**
     * Description for badge
     *
     * @var string
     */
    protected $description = 'have more than 5 badges';
    protected $name = 'The Expert';
    protected $level = 4;


    /**
     * Check is user qualifies for badge
     *
     * @param $user
     * @return bool
     */
    public function qualifier($user)
    {
        return $user->badges()->count()>=200;
    }
}
