<?php

namespace App\Gamify\Badges;

use App\Models\User;
use Carbon\Carbon;
use QCod\Gamify\BadgeType;

class Month1 extends BadgeType
{
    /**
     * Description for badge
     *
     * @var string
     */
    protected $description = 'member in Learnify for 1 month';
    protected $name = '1 Month Member';
    protected $level = 1;
    /**
     * Check is user qualifies for badge
     *
     * @param $user
     * @return bool
     */
    public function qualifier($user)
    {
        return Carbon::parse($user->created_at)->diffInMonths(Carbon::now()) > 1 ;
    }
}
