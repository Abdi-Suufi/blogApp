<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'bio',
        'is_admin',
        'profile_picture',
        'last_active_at',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_active_at' => 'datetime',
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // Define an accessor for the online status
    public function getIsOnlineAttribute()
    {
        return $this->last_active_at && $this->last_active_at->diffInMinutes(now()) < 5;
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Define the relationship for followers.
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id');
    }

    /**
     * Define the relationship for following.
     */
    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id');
    }

    /**
     * Follow a user.
     *
     * @param User $user
     * @return void
     */
    public function follow(User $user)
    {
        $this->following()->attach($user->id);
    }

    /**
     * Unfollow a user.
     *
     * @param User $user
     * @return void
     */
    public function unfollow(User $user)
    {
        $this->following()->detach($user->id);
    }

    /**
     * Check if the user is following another user.
     *
     * @param User $user
     * @return bool
     */
    public function isFollowing(User $user)
    {
        return $this->following()->where('followed_id', $user->id)->exists();
    }

    public function followersCount()
    {
        return $this->followers()->count();
    }
}
