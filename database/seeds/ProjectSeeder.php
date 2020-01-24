<?php

<<<<<<< HEAD
use App\Models\Project;
=======
use App\Models\IssueState;
use App\Models\Project;
use App\Models\User;
>>>>>>> 902f24bbe063dc0a8b789684333ba2714dff00eb
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
<<<<<<< HEAD
        for($i=0;$i<5;$i++){
            factory(Project::class)->create();
        }
=======
        $user = User::whereEmail('admin@bugspring.test')->first();

        factory(Project::class, 5)->create([
            'owner_id' => $user->id,
        ])->each(function($project) {
            factory(IssueState::class,5)->create([
                'project_id' => $project->id
            ]);
        });
>>>>>>> 902f24bbe063dc0a8b789684333ba2714dff00eb
    }
}
