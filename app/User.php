<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'owner_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'owner_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public static function admin()
    {
        return static::where('email',env('ADMIN_EMAIL')) -> first();
    }

    public function userName(User $user)
    {
        return $user->name;
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

}
