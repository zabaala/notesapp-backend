<?php

namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use \App\Domains\Notes\Note;
use Faker\Generator as Faker;

$factory->define(Note::class, function (Faker $faker) {
    return [
        'title' => $faker->text(124),
        'text' => $faker->paragraph
    ];
});
