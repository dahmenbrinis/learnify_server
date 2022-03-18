<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property User $user
 */
class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['voteCount'];

    public function getVoteCountAttribute()
    {
        return $this->votes()->count();
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imagable');
    }

    public function votes(): MorphMany
    {
        return $this->morphMany(Vote::class, 'votable');
    }
}
