<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property int $visibility
 * @property int $id
 * @property User $creator
 * @property Question $questions
 * @property Collection<User> $users
 * @method static find(int $id)
 */
class Room extends Model
{
    static array $permissions = ['can_viewAny' , 'can_view' , 'can_update' , 'can_delete' , 'can_ask' ];
    public static int $PrivateRoom = 0;
    public static int $PublicRoom = 1;
    public static array $Visibilities = [0 => 'Private', 1 => 'Public'];
    use HasFactory;

    protected $guarded = [];
    protected $hidden = ['creator'];
    protected $appends = ['imageId', 'permissions', 'userCount', 'questionsCount', 'answersCount', 'visibilityName'];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imagable');
    }

    public function getImageIdAttribute()
    {
        return $this->image->id ?? null;
    }


    public function getVisibilityNameAttribute(): string
    {
        return self::$Visibilities[$this->visibility];
    }

    public function getUserCountAttribute(): int
    {
        return $this->users()->count();
    }

    public function getQuestionsCountAttribute(): int
    {
        return $this->questions()->count();
    }

    public function getAnswersCountAttribute(): int
    {
        return 50;
    }


    public function getPermissionsAttribute(): array
    {
        $result = array_fill_keys(self::$permissions,false);
        if(Auth::user())
            foreach( $result as $key => $value)
                $result[$key]= Auth::user()->can(substr($key, 4), $this);
        return $result;
    }
}
