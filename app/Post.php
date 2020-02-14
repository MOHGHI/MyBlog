<?php

namespace App;

use App\Events\PostCreated;
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

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function addTags($new = false)
    {
        $tags = collect(explode(',', \request('tags')))->keyBy(function ($item) {
            return $item;
        });
        if(!$new) {
            /** @var Collection $postTag */
            $postTag = $this->tags->keyBy('name');
            $syncIds = $postTag->intersectByKeys($tags)->pluck('id')->toArray();
            $tagsToAttach = $tags->diffKeys($postTag);
            foreach ($tagsToAttach as $tag)
            {
                $tag = Tag::firstOrCreate(['name' => $tag]);
                $syncIds[] = $tag->id;
            }

        } else {
            $syncIds = [];
            foreach ($tags as $tag) {
                $tag = Tag::firstOrCreate(['name' => $tag]);
                $syncIds[] = $tag->id;
            }
        }
        $this->tags()->sync($syncIds);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

}
