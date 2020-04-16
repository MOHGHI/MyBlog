<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;

class CommentsController extends Controller
{

    public function store($model)
    {
        $request_arr = $this->validate(request(), [
            'title' => 'required |min:5 |max:100',
            'comment' => 'required |max:255',
        ]);
        $request_arr['owner_id'] = auth()->id();
        $comment = Comment::Create($request_arr);
        $model->comments()->save($comment);
        return back();
    }

}
