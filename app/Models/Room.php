<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $visibility
 * @property int $id
 */
class Room extends Model
{
    public static $PrivateRoom = 0 ;
    public static $PublicRoom = 1 ;
    public static $Visibilities = [0=>'Private' , 1=>'Public'] ;
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['creator'];
    protected $appends = ['permissions','userCount','questionsCount','answersCount','visibilityName'];

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
    public function creator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'creator_id');
    }

    public function getVisibilityNameAttribute(): string
    {
//        dd($this->visibility);
        return self::$Visibilities[$this->visibility];
//        return  '';
    }

    public function getUserCountAttribute(): int
    {
//        dd($this->users);
        return $this->users()->count();
    }
    public function getQuestionsCountAttribute(): int
    {
        return 50;
    }
    public function getAnswersCountAttribute(): int
    {
        return 50;
    }


    public function getPermissionsAttribute(): array
    {
        return [
            'can_viewAny'=>Auth::user()->can('viewAny',$this),
            'can_view'=>Auth::user()->can('view',$this),
            'can_update'=>Auth::user()->can('update',$this),
            'can_delete'=>Auth::user()->can('delete',$this),
            'can_ask'=>Auth::user()->can('askQuestion',$this),
//            'can_viewLeaderBoard'=>Auth::user()->can('askQuestion',$this),
        ];
    }
}
