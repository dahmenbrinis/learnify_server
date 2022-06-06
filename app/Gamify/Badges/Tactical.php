<?php

namespace App\Gamify\Badges;

use QCod\Gamify\BadgeType;

class Tactical extends BadgeType
{
    /**
     * Description for badge
     *
     * @var string
     */
    protected $description = 'reach 10 valid answers without exceeding 40 answers';
    protected $name = 'Pin Point Accurate';
    protected $level = 4;
    /**
     * Check is user qualifies for badge
     *
     * @param $user
     * @return bool
     */
    public function qualifier($user)
    {
        return $user->validComments()->count()==10 && $user->comments()->count()<=40;
    }
}
