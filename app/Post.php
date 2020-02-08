<?php

namespace App;

use App\Events\PostCreated;

class Post extends Model
{
    protected $dispatchesEvents = [
        'created' => PostCreated::class,
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

}
