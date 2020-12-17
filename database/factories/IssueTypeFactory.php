<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\IssueType;
use App\Util\MaterialDesignIcons;
use Faker\Generator as Faker;

$factory->define(IssueType::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'icon'  => $faker->randomElement(MaterialDesignIcons::NAMES)
    ];
});
