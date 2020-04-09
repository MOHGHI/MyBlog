<?php

namespace App;

use App\Events\PostCreated;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Post extends Model
{
    protected $dispatchesEvents = [
        'created' => PostCreated::class,
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();

        static::updating(function (Post $post) {
            $after = $post->getDirty();
            $post->history()->attach(auth()->id(), [
                'before' => json_encode(Arr::only($post->fresh()->toArray(), array_keys($after))),
                'after'  => json_encode($after),
            ]);
        });
    }


//    public function addTags($tags)
//    {
//        if(!$this->tags()->exists()) {
//            /** @var Collection $postTag */
//            $postTag = $this->tags->keyBy('name');
//            $syncIds = $postTag->intersectByKeys($tags)->pluck('id')->toArray();
//            $tagsToAttach = $tags->diffKeys($postTag);
//            foreach ($tagsToAttach as $tag)
//            {
//                $tag = Tag::firstOrCreate(['name' => $tag]);
//                $syncIds[] = $tag->id;
//            }
//
//        } else {
//            $syncIds = [];
//            foreach ($tags as $tag) {
//                $tag = Tag::firstOrCreate(['name' => $tag]);
//                $syncIds[] = $tag->id;
//            }
//        }
//        $this->tags()->sync($syncIds);
//    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function comments()
    {
        return $this->morphToMany(Comment::class, 'commentable');
    }

    public function  history()
    {
        return $this->belongsToMany(User::class, 'post_histories')
            ->withPivot(['before', 'after'])->withTimestamps();
    }


}
