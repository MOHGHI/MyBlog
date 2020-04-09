<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'commentable');
    }

    public function news()
    {
        return $this->morphedByMany(News::class, 'commentable');
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
