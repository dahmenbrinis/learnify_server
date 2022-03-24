<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property User $user
 * @property Question|Comment $votable
 */
class Vote extends Model
{
    use HasFactory;
    protected $fillable = ['votable_type' , 'votable_id'];
    protected $appends = ['user'];

    public function  getUserAttribute(){
        return $this->user()->get();
    }

    public function votable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
