<?php

namespace App\Gamify\Badges;

use App\Models\User;
use App\Models\Vote;
use Illuminate\Support\Facades\DB;
use QCod\Gamify\BadgeType;

class WellRecognized extends BadgeType
{
    /**
     * Description for badge
     *
     * @var string
     */
    protected $description = 'make 50 votes';
    protected $name = 'Rockstar';
    protected $level = 3;
    /**
     * Check is user qualifies for badge
     *
     * @param $user
     * @return bool
     */
    public function qualifier($user)
    {
        return $user->votes()->count()>=50;
    }
}
