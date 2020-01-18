<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\IssueState;
use App\Util\MaterialDesignIcons;
use Faker\Generator as Faker;

$factory->define(IssueState::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'icon' => $faker->randomElement(MaterialDesignIcons::NAMES)
    ];
});
