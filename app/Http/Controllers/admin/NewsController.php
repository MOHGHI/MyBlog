<?php

namespace App\Http\Controllers\admin;

use App\News;
use App\User;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    public function publish(News $news)
    {
        $news->update(['published' => true]);
        return back();
    }

    public function unpublish(News $news)
    {
        $news->update(['published' => false]);
        return back();
    }
}
