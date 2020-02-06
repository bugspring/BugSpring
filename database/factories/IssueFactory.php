<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Issue;
use App\Models\IssueState;
use App\Models\Project;
use Faker\Generator as Faker;

$factory->define(Issue::class, function (Faker $faker) {
    $project_id = Project::all()->random()->id;
    return [
        'name' => $faker->text(32),
        'project_id' => $project_id,
        'issue_state_id' => factory(IssueState::class)->create(['project_id' => $project_id])->id
    ];
});
