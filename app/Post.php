<?php

namespace App;

class Post extends Model
{
    //
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeIncomplete($query)
    {
        return $query->where('completed', '0');
    }
}
