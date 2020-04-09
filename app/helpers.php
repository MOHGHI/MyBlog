<?php

use App\Tag;
use Illuminate\Database\Eloquent\Collection;

if(!function_exists('flash'))
{
    /**
     * @param $message
     * @param string $type
     */
    function flash($message, $type = 'success')
    {
        session()->flash('message', $message);
        session()->flash('message_type', $type);
    }
}


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

function addComments($model, $comment)
{
    $comment = \App\Comment::Create($comment);
    $model->comments()->sync($comment->id);
}
