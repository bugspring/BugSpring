<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Bouncer;

class ProjectPermissionTest extends TestCase
{
    use DatabaseTransactions;

    const BASE_PATH = '/api/project';

    /** @var User $user */
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    public function testIndexOnlyListsProjectsWithReadPermission()
    {
        Passport::actingAs($this->user);

        $otherUser = factory(User::class)->create();

        // These projects should be returned by /api/project
        $ownProjects = factory(Project::class, 50)->create([
            'owner_id' => $this->user->id,
            'description' => 'own',
        ]);
        $linkedProjects = factory(Project::class, 50)->create([
            'owner_id' => $otherUser->id,
            'description' => 'linked with permission',
        ])->each(function(Project $project) {
            $project->users()->attach($this->user);
            $this->user->allow('read', $project);
        });
        $visibleProjects = $ownProjects->merge($linkedProjects);

        // These projects should not be returned by /api/project
        $invisibleLinkedProjects = factory(Project::class, 1)->create([
            'owner_id' => $otherUser->id,
            'description' => 'linked NO permission',
        ])->each(function(Project $project) {
            $project->users()->attach($this->user);
        });
        $notLinkedProjects = factory(Project::class, 1)->create([
            'owner_id' => $otherUser->id,
            'description' => 'not linked',
        ]);


        $this->json('GET',self::BASE_PATH, [])
            ->assertStatus(200)
            ->assertJsonCount($visibleProjects->count())
            ->assertJson($visibleProjects->toArray());
    }

    public function testStoreNeedsCreatePermission()
    {
        Passport::actingAs($this->user);

        $projectData = [
            'name' => 'My super awesome project!',
            'description' => 'It does all you need'
        ];

        $this->json('POST', self::BASE_PATH, $projectData)
            ->assertStatus(201)
            ->assertJson($projectData);

        Bouncer::forbid($this->user)->to('create', Project::class);
        Bouncer::refresh();

        $this->json('POST', self::BASE_PATH, $projectData)
            ->assertStatus(403);
    }

    public function testShowNeedsReadPermission()
    {
        Passport::actingAs($this->user);

        $project = factory(Project::class)->create([
            'owner_id' => $this->user->id,
        ]);

        $this->json('GET', self::BASE_PATH . "/{$project->id}")
            ->assertStatus(200)
            ->assertJson($project->toArray());

        Bouncer::forbid($this->user)->to('read', $project);
        Bouncer::refresh();

        $this->json('GET', self::BASE_PATH . "/{$project->id}")
            ->assertStatus(403);
    }

    public function testUpdateNeedsUpdatePermission()
    {
        Passport::actingAs($this->user);

        $project = factory(Project::class)->create([
            'owner_id' => $this->user->id,
        ]);

        $updateData = [
            'name' => 'My super awesome project!',
            'description' => 'It does all you need'
        ];

        $this->json('PUT', self::BASE_PATH . "/{$project->id}", $updateData)
            ->assertStatus(200)
            ->assertJson($updateData);

        Bouncer::forbid($this->user)->to('update', $project);
        Bouncer::refresh();

        $this->json('PUT', self::BASE_PATH . "/{$project->id}", $updateData)
            ->assertStatus(403);
    }

    public function testDestroyNeedsDeletePermission()
    {
        Passport::actingAs($this->user);

        $project = factory(Project::class)->create([
            'owner_id' => $this->user->id,
        ]);

        $this->json('DELETE', self::BASE_PATH . "/{$project->id}")
            ->assertStatus(200)
            ->assertJson($project->toArray());



        $project = factory(Project::class)->create([
            'owner_id' => $this->user->id,
        ]);
        Bouncer::forbid($this->user)->to('delete', $project);
        Bouncer::refresh();


        $this->json('DELETE', self::BASE_PATH . "/{$project->id}")
            ->assertStatus(403);
    }

}
