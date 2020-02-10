<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
       'title' => $faker->sentence,
       'slug' => \Str::slug($faker->sentence),
       'user_id' => 1,
       'active' => $faker->numberBetween(0,1)
    ];
});
