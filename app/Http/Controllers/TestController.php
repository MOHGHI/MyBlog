<?php


namespace App\Http\Controllers;


use App\Post;

class TestController
{
    public function test()
    {

        $from = '2020.02.13' ;
        $to = '2020.02.14';
//        $from = '13.02.2020' ;
//        $to = '14.02.2020';
        $from = date("Y-m-d", strtotime($from));
        $to = date("Y-m-d", strtotime($to));
        $posts = Post::where([
            ['published', true],
            ['created_at','>=', $from],
            ['created_at','<=', $to],
        ])->latest()->get();
        dd(strtotime($from));
    }
}