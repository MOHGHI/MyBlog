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

    public static function commentValidation()
    {
        $request_arr = request()->validate([
            'title' => 'required |min:5 |max:100',
            'comment' => 'required |max:255',
        ]);

        $request_arr['owner_id'] = auth()->id();
        return $request_arr;
    }
}
