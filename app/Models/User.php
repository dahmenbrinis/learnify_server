<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property Collection $questions
 * @property Collection<Room> $rooms
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public static $Teacher = 0;
    public static $Student = 1;
    public static $typeNames = [0 => 'Teacher', 1 => 'Student'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getTypeNameAttribute(): string
    {
        return self::$typeNames[$this->type];
    }


    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
