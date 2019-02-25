<?php

use Faker\Generator as Faker;
use Modules\Article\Entities\Article;

$factory->define(Article::class, function (Faker $faker) {
    return [
      'title' => $faker->sentence(3),
      'url_key' => $faker->slug,
      'content' => $faker->text(1200)
    ];
});
