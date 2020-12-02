<?php

namespace Tests\Feature;

use App\Models\IssueState;
use App\Models\Project;
use App\Models\User;
use Bouncer;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ProjectApiTest extends TestCase
{
    use DatabaseTransactions;

    const BASE_PATH = '/api/project';
    const JSON_STRUCTURE = [
        'id',
        'owner_id',
        'name',
        'description',
        'created_at',
        'updated_at',

        'issue_states' => [
            '*' => [
                'id',
                'title',
                'icon',
            ],
        ],
    ];

    /** @var User $user */
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        Bouncer::allow($this->user)->everything();
    }

    public function testCanStoreProjectWithIssueStates()
    {
        Passport::actingAs($this->user);

        $projectData = [
            'name' => "BugSpring",
            'description' => "A modern Issue Tracker...",
            'issue_states' => [
                [
                    'title' => "open",
                    'icon' => "mdi-checkbox-multiple-blank-outline"
                ],
                [
                    'title' => "in dev",
                    'icon' => "mdi-progress-wrench"
                ],
                [
                    'title' => "fixed",
                    'icon' => "mdi-check-box-multiple-outline"
                ],
                [
                    'title' => "won't fix",
                    'icon' => "mdi-close-box-multiple"
                ]
            ],
        ];

        $this->json('POST', self::BASE_PATH, $projectData)
            ->assertStatus(201)
            ->assertJsonStructure(self::JSON_STRUCTURE)
            ->assertJson($projectData);

        $this->assertDatabaseHas('projects', [
            'name' => $projectData['name'],
            'description' => $projectData['description']
        ]);
        foreach($projectData['issue_states'] as $issue_state)
        {
            $this->assertDatabaseHas('issue_states', $issue_state);
        }
    }

    public function testCanAddIssueStatesToProject()
    {
        Passport::actingAs($this->user);

        $project = factory(Project::class)->create([
            'owner_id' => $this->user
        ]);

        $issue_states = [
            [
                'title' => "open",
                'icon' => "mdi-checkbox-multiple-blank-outline"
            ],
            [
                'title' => "in dev",
                'icon' => "mdi-progress-wrench"
            ],
            [
                'title' => "fixed",
                'icon' => "mdi-check-box-multiple-outline"
            ],
            [
                'title' => "won't fix",
                'icon' => "mdi-close-box-multiple"
            ]
        ];

        $this->json('PUT', self::BASE_PATH . "/{$project->id}", ['issue_states' => $issue_states])
            ->assertStatus(200)
            ->assertJson(['issue_states' => $issue_states]);

        foreach($issue_states as $issue_state)
        {
            $this->assertDatabaseHas('issue_states', $issue_state);
        }

    }

    public function testCanUpdateIssueStatesFromProject()
    {
        Passport::actingAs($this->user);

        $project = factory(Project::class)->create([
            'owner_id' => $this->user
        ]);
        $issue_states = factory(IssueState::class, 4)->create([
            'project_id' => $project->id
        ]);

        $issue_state_data = [
            [
                'id' => $issue_states[0]->id,
                'title' => "open",
                'icon' => "mdi-checkbox-multiple-blank-outline"
            ],
            [
                'id' => $issue_states[1]->id,
                'title' => "in dev",
                'icon' => "mdi-progress-wrench"
            ],
            [
                'id' => $issue_states[2]->id,
                'title' => "fixed",
                'icon' => "mdi-check-box-multiple-outline"
            ],
            [
                'id' => $issue_states[3]->id
            ]
        ];

        $this->json('PUT', self::BASE_PATH . "/{$project->id}", ['issue_states' => $issue_state_data])
            ->assertStatus(200)
            ->assertJson(['issue_states' => $issue_state_data]);

        foreach($issue_state_data as $issue_state)
        {
            $this->assertDatabaseHas('issue_states', $issue_state);
        }
    }

    public function testCanRemoveIssueStatesFromProject()
    {
        Passport::actingAs($this->user);

        $project = factory(Project::class)->create([
            'owner_id' => $this->user
        ]);
        $issue_states = factory(IssueState::class, 4)->create([
            'project_id' => $project->id
        ]);

        $issue_state_data = [
            ['id' => $issue_states[0]->id],
            ['id' => $issue_states[2]->id],
        ];

//        dd($this->json('PUT', self::BASE_PATH . "/{$project->id}", ['issue_states' => $issue_states])->baseResponse->content());
        $this->json('PUT', self::BASE_PATH . "/{$project->id}", ['issue_states' => $issue_state_data])
            ->assertStatus(200)
            ->assertJson(['issue_states' => $issue_state_data]);

        foreach($issue_state_data as $issue_state)
        {
            $this->assertDatabaseHas('issue_states', $issue_state);
        }
    }


    public function testProjectCanBeFavored()
    {
        Passport::actingAs($this->user);

        // create Project
        $project = factory(Project::class)->create();
        $projectData = $project->toArray();
        $this->assertFalse($projectData['is_favorite']);

        // make project favorite
        $projectData['is_favorite'] = true;

        $this->json('PUT', self::BASE_PATH . "/{$project->id}", $projectData)
            ->assertStatus(200);

        $this->json('GET', self::BASE_PATH . "/{$project->id}")
            ->assertJson(['is_favorite'=>true]);

        // make project no favorite
        $projectData['is_favorite'] = false;

        $this->json('PUT', self::BASE_PATH . "/{$project->id}", $projectData)
            ->assertStatus(200);

        $this->json('GET', self::BASE_PATH . "/{$project->id}")
            ->assertJson(['is_favorite'=>false]);
    }

    public function testIndexReturnsAllOwnedAndLinkedProjects()
    {
        Passport::actingAs($this->user);
        $otherUser = factory(User::class)->create();

        factory(Project::class, 50)->create([
            'owner_id' => $this->user->id,
        ])->each(function (Project $project)  {
            $project->issue_states()->saveMany(factory(IssueState::class, 5)->make());
        });

        factory(Project::class, 50)->create([
            'owner_id' => $otherUser->id
        ])->each(function(Project $project){
            $project->issue_states()->saveMany(factory(IssueState::class, 5)->make());
            $project->users()->save($this->user);
        });

        $this->json('GET',self::BASE_PATH, [])
            ->assertStatus(200)
            ->assertJsonStructure([
            '*' => self::JSON_STRUCTURE
        ])->assertJsonCount(100);
    }

    public function testStoreCreatesAProjectInTheDatabase()
    {
        Passport::actingAs($this->user);

        $projectData = [
            'name' => "BugSpring",
            'description' => "A modern Issue Tracker...",
        ];

        $this->json('POST', self::BASE_PATH, $projectData)
            ->assertStatus(201)
            ->assertJsonStructure(self::JSON_STRUCTURE)
            ->assertJson($projectData);

        $this->assertDatabaseHas('projects', $projectData);
    }

    public function testStoreNeedsNameProperty()
    {
        Passport::actingAs($this->user);

        $this->json('POST', self::BASE_PATH, [
            'description' => "A modern Issue Tracker...",
        ])->assertStatus(422);
    }

    public function testStoreNeedsDescriptionProperty()
    {
        Passport::actingAs($this->user);

        $this->json('POST', self::BASE_PATH, [
            'name' => "BugSpring",
        ])->assertStatus(422);
    }

    public function testShowReturnsOneProject()
    {
        Passport::actingAs($this->user);

        $project = factory(Project::class)->create([
            'owner_id' => $this->user->id,
        ]);

        $this->json('GET', self::BASE_PATH . "/{$project->id}")
            ->assertStatus(200)
            ->assertJsonStructure(self::JSON_STRUCTURE)
            ->assertJson($project->toArray());

    }

    public function testUpdateModifiesAProjectInTheDatabase()
    {
        Passport::actingAs($this->user);

        /** @var Project $project */
        $project = factory(Project::class)->create([
            'owner_id' => $this->user->id
        ]);
        /** @var User $otherUser */
        $otherUser = factory(User::class)->create();

        $updateData = [
            'owner_id' => $otherUser->id,
            'name' => 'My super awesome project!',
            'description' => 'Is now owned by someone else...'
        ];

        $this->json('PUT', self::BASE_PATH . "/{$project->id}", $updateData)
            ->assertStatus(200)
            ->assertJsonStructure(self::JSON_STRUCTURE)
            ->assertJson($updateData);

        $this->assertDatabaseHas('projects', $updateData);
    }

    public function testUpdateCanChangeOwner()
    {
        /** @var User $otherUser */
        $otherUser = factory(User::class)->create();

        $this->updateProperty('owner_id', $otherUser->id);
    }

    public function testUpdateCanChangeName()
    {
        $this->updateProperty('name', 'My super awesome project!');
    }

    public function testUpdateCanChangeDescription()
    {
        $this->updateProperty('description', 'Infos about my super awesome project!');
    }

    public function updateProperty($property, $value)
    {
        Passport::actingAs($this->user);

        /** @var Project $project */
        $project = factory(Project::class)->create([
            'owner_id' => $this->user->id
        ]);

        $this->json('PUT', self::BASE_PATH . "/{$project->id}", [
            $property => $value
        ])
            ->assertStatus(200)
            ->assertJsonStructure(self::JSON_STRUCTURE)
            ->assertJson([
                $property => $value
            ]);

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            $property => $value
        ]);
    }

    public function testUpdateNeedsExistingOwnerId()
    {
        Passport::actingAs($this->user);

        /** @var Project $project */
        $project = factory(Project::class)->create([
            'owner_id' => $this->user->id
        ]);

        $this->json('PUT', self::BASE_PATH . "/{$project->id}", ['owner_id' => 0])
            ->assertStatus(422);
    }

    public function testDestroyDeletesTheProjectInTheDatabase()
    {
        Passport::actingAs($this->user);

        /** @var Project $project */
        $project = factory(Project::class)->create([
            'owner_id' => $this->user->id
        ]);

        $this->json('DELETE', self::BASE_PATH . "/{$project->id}")
            ->assertStatus(200)
            ->assertJsonStructure(self::JSON_STRUCTURE)
            ->assertJson($project->toArray());

        $this->assertDatabaseMissing('projects',['id' => $project->id]);
    }


}
