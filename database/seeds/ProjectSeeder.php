<?php

use App\Models\IssueState;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::whereEmail('admin@bugspring.test')->first();

        factory(Project::class, 5)->create([
            'owner_id' => $user->id,
        ])->each(function($project) {
            factory(IssueState::class,5)->create([
                'project_id' => $project->id
            ]);
        });
    }
}
