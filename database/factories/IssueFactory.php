<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Issue;
use App\Models\IssueType;
use App\Models\Project;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Issue::class, function (Faker $faker) {
    $project_id = Project::all()->random()->id;
    return [
        'name'          => $faker->text(32),
        'project_id'    => $project_id,
        'issue_type_id' => factory(IssueType::class)->create(['project_id' => $project_id])->id,
        'creator'       => User::all()->random()->id,
        'assignee'      => $faker->optional()->passthrough(User::all()->random()->id)
    ];
});
