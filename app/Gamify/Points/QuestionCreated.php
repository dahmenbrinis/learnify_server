<?php

namespace App\Gamify\Points;

use App\Models\Room;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\This;
use QCod\Gamify\PointType;

class QuestionCreated extends PointType
{
    /**
     * Number of points
     *
     * @var int
     */
    public $points = 3;
    public User $user ;
    /**
     * Point constructor
     *
     * @param $subject
     */
    public function __construct(Room $subject   )
    {
        $this->subject = $subject;
//        $this->user = $user ;
    }

    /**
     * User who will be receive points
     *
     * @return mixed
     */
    public function payee()
    {
        return Auth::user();
    }

    public function qualifier()
    {
        return Auth::user()->can('dailyReputation',[$this->getSubject(),'QuestionCreated']);
    }
}
