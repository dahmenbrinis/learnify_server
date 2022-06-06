<?php

namespace App\Gamify\Badges;

use Carbon\Carbon;
use QCod\Gamify\BadgeType;

class Month12 extends BadgeType
{
    /**
     * Description for badge
     *
     * @var string
     */
    protected $description = 'member in Learnify for 1 year';
    protected $name = '1 Year Member';
    protected $level = 3;
    /**
     * Check is user qualifies for badge
     *
     * @param $user
     * @return bool
     */
    public function qualifier($user)
    {
        return Carbon::parse($user->created_at)->diffInMonths(Carbon::now()) > 12;
    }
}
