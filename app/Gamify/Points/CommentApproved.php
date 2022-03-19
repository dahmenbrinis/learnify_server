<?php

namespace App\Gamify\Points;

use App\Models\Room;
use App\Models\User;
use QCod\Gamify\PointType;

class CommentApproved extends PointType
{
    /**
     * Number of points
     *
     * @var int
     */
    public $points = 10;
    private User $user;

    /**
     * Point constructor
     *
     * @param $subject
     */
    public function __construct(Room $subject , User $user)
    {
        $this->subject = $subject;
        $this->user = $user ;
    }

    /**
     * User who will be receive points
     *
     * @return mixed
     */
    public function payee()
    {
        return $this->user;
    }
}
