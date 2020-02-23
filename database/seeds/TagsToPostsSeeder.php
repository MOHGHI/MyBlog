<?php

use Illuminate\Database\Seeder;

class TagsToPostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = \App\Tag::all();
        \App\Post::all()->each(function ($post) use ($tags){
            $post->tags()->attach(
              $tags->random(rand(1,3))->pluck('id')->toArray()
            );
        });
    }
}
