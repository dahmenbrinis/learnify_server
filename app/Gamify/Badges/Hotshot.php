<?php

namespace App\Gamify\Badges;

use App\Models\Comment;
use App\Models\User;
use QCod\Gamify\BadgeType;

class Hotshot extends BadgeType
{
    /**
     * Description for badge
     *
     * @var string
     */
    protected $description = 'post the first answer 30 times ';
    protected $name = 'Hotshot';
    protected $level = 2;
    /**
     * Check is user qualifies for badge
     *
     * @param $user
     * @return bool
     */
    public function qualifier($user)
    {
        $ValidationCount = 0 ;
        $user->comments()->each(function (Comment $comment) use (&$ValidationCount){
            $question = $comment->question ;
            if($question->comments()->orderBy('comments.created_at')->first()->id == $comment->id)
                $ValidationCount++;
        });
        return $ValidationCount >= 30 ;
    }
}
