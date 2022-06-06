<?php

namespace App\Gamify\Badges;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use QCod\Gamify\BadgeType;

class Brainiac extends BadgeType
{
    /**
     * Description for badge
     *
     * @var string
     */
    protected $description = 'reach 400 points';
    protected $name = 'Brainiac';
    protected $level = 4;


    /**
     * Check is user qualifies for badge
     *
     * @param $user
     * @return bool
     */
    public function qualifier($user)
    {
        return $user->getPoints()>=400;
    }
}
