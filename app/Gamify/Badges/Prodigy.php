<?php

namespace App\Gamify\Badges;

use QCod\Gamify\BadgeType;

class Prodigy extends BadgeType
{
    /**
     * Description for badge
     *
     * @var string
     */
    protected $description = 'reach 50 valid answers';
    protected $name = 'Prodigy';
    protected $level = 3;
    /**
     * Check is user qualifies for badge
     *
     * @param $user
     * @return bool
     */
    public function qualifier($user)
    {
        return $user->validComments()->count()>=50;
    }
}
