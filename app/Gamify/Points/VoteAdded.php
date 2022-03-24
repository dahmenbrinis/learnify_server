<?php

namespace App\Gamify\Points;

use App\Models\User;
use App\Models\Vote;
use Auth;
use QCod\Gamify\PointType;

class VoteAdded extends PointType
{
    /**
     * Number of points
     *
     * @var int
     */
    public $points = 1;
    public ?Vote $vote = null ;

    /**
     * Point constructor
     *
     * @param $subject
     */
    public function __construct($subject , Vote $vote)
    {
        $this->subject = $subject;
        $this->vote = $vote;
    }

    /**
     * User who will be receive points
     *
     * @return User
     */
    public function payee(): User
    {
        return $this->vote->votable->user;
    }
}
