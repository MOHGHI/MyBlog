<?php

namespace App;

class Feedback extends Model
{
    //
    public $table = "feedbacks";

    public function scopeIncomplete($query)
    {
        return $query->where('id', '0');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
