<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;

/**
 * @method static create(array $validated)
 * @property Room room
 * @property User user
 * @property string $description
 */
class Question extends Model
{
    use HasFactory;

    protected $guarded = [];
    static array $permissions = ['can_viewAny', 'can_view', 'can_update', 'can_delete', 'can_create'];
    protected $appends = ['permissions', 'voteCount', 'answersCount'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function getAnswersCountAttribute(): int
    {
        return 50;
    }

    public function getVoteCountAttribute(): int
    {
        //TODO : add the voting count implementation
        return 50;
    }

    public function getPermissionsAttribute(): array
    {
        $result = array_fill_keys(self::$permissions, false);
        if (Auth::user())
            foreach ($result as $key => $value)
                $result[$key] = Auth::user()->can(substr($key, 4), [$this->room, $this]);
        return $result;
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->with('votes');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imagable');
    }
}
