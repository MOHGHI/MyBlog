<?php


namespace App\Service;


use App\Tag;
use Illuminate\Database\Eloquent\Collection;

class AddTags
{
    function addTags($model, $tags)
    {
        if(!$model->tags()->exists()) {
            /** @var Collection $modelTag */
            $modelTag = $model->tags->keyBy('name');
            $syncIds = $modelTag->intersectByKeys($tags)->pluck('id')->toArray();
            $tagsToAttach = $tags->diffKeys($modelTag);
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
        $model->tags()->sync($syncIds);
    }
}