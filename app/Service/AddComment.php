<?php


namespace App\Service;


use App\Comment;
use App\Model;

class AddComment
{
    public function addComments(Model $model, $comment_attr)
    {
        $comment = \App\Comment::Create($comment_attr);
        $model->comments()->save($comment);
        return back();
    }
}