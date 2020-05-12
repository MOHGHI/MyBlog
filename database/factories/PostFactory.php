<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->words(3,true),
        'body' => $faker->sentence,
        'slug' => $faker->unique()->word,
        'short_body' => $faker->sentence(6,true),
        'owner_id' =>  \App\User::inRandomOrder()->limit(1)->pluck('id')->pop(),
    ];
});
