<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;
use QCod\Gamify\Gamify;

/**
 * @property Collection $questions
 * @property Collection<Room> $rooms
 * @property int $type
 * @property string $name
 * @property string $fcm_token
 * @method static create(array $attr)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Gamify;

    public static int $Teacher = 0;
    public static int $Student = 1;
    public static array $typeNames = [0 => 'Teacher', 1 => 'Student'];

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
        'fcm_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'fcm_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['imageId','points'];

    public function getPointsAttribute()
    {
        return $this->getPoints(true);
    }

    public function getImageIdAttribute()
    {
        return $this->profileImage->id ?? null;
    }


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

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function profileImage(): MorphOne
    {
        return $this->morphOne(Image::class, 'imagable');
    }

    public function allImages(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Specifies the user's FCM token
     *
     * @return string|array
     */
    public function routeNotificationForFcm()
    {
        return $this->fcm_token;
    }
}
