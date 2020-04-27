<?php


namespace App\Service;


use App\Model;

class AddComment
{
    public function addComments(Model $model)
    {
        $request_arr = request()->validate([
            'title' => 'required |min:5 |max:100',
            'comment' => 'required |max:255',
        ]);

        $request_arr['owner_id'] = auth()->id();
        $comment = \App\Comment::Create($request_arr);
        $model->comments()->save($comment);
        return back();
    }
}