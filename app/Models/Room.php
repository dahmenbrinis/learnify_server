<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $visibility
 * @property int $id
 * @property User $creator
 */
class Room extends Model
{
    static $permissions = ['can_viewAny' , 'can_view' , 'can_update' , 'can_delete' , 'can_ask' ];
    public static $PrivateRoom = 0;
    public static $PublicRoom = 1;
    public static $Visibilities = [0 => 'Private', 1 => 'Public'];
    use HasFactory;

    protected $guarded = [];
    protected $hidden = ['creator'];
    protected $appends = ['permissions', 'userCount', 'questionsCount', 'answersCount', 'visibilityName'];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
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

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
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
        if(!Auth::user()) return array_fill_keys(self::$permissions,false);
        return array_map(fn($key)=>[$key=>Auth::user()->can(substr($key, 4), $this)],self::$permissions);
    }
}
