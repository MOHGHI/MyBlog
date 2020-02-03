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
}
