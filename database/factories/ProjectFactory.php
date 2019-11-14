<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Project;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'owner_id' => User::all()->random()->first()->id,
        'name' => $faker->company,
        'description' => $faker->text,
    ];
});
