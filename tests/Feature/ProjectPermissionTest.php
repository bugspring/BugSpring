<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Bouncer;

class ProjectPermissionTest extends TestCase
{
    const BASE_PATH = '/api/project';

    /** @var User $user */
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndexOnlyListsProjectsWithReadPermission()
    {
        Passport::actingAs($this->user);

        $otherUser = factory(User::class)->create();

        // These projects should be returned by /api/project
        $ownProjects = factory(Project::class, 10)->create([
            'owner_id' => $this->user->id
        ]);
        $linkedProjects = factory(Project::class, 10)->create([
            'owner_id' => $otherUser->id
        ])->each(function(Project $project) {
            $project->users()->attach($this->user);
            $this->user->allow('read', $project);
        });

        // These projects should not be returned by /api/project
        $invisibleLinkedProjects = factory(Project::class, 10)->create([
            'owner_id' => $otherUser->id
        ])->each(function(Project $project) {
            $project->users()->attach($this->user);
        });
        $notLinkedProjects = factory(Project::class)->create([
            'owner_id' => $otherUser->id
        ]);

        $visibleProjects = $ownProjects->merge($linkedProjects);

        $this->json('GET',self::BASE_PATH, [])
            ->assertStatus(200)
            ->assertJsonCount($visibleProjects->count())
            ->assertJson($visibleProjects->toArray());

    }
}
