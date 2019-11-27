<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Issue;
use App\Models\Project;
use Faker\Generator as Faker;

$factory->define(Issue::class, function (Faker $faker) {
    return [
        'name' => $faker->text(32),
        'project_id' => Project::all()->random()->id,
    ];
});
