<?php

namespace Tests\Feature;

use App\Models\IssueState;
use Bouncer;
use App\Models\Issue;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class IssuePermissionTest extends TestCase
{
    use DatabaseTransactions;

    const BASE_PATH = '/api/project/%d/issue';

    private $basePath;

    /** @var User $user */
    private $user;
    /** @var Project $project */
    private $project;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->project = factory(Project::class)->create([
            'owner_id' => $this->user->id,
        ]);

        $this->basePath = sprintf(self::BASE_PATH, $this->project->id);
    }


    public function testIndexOnlyListsIssuesWithReadPermission()
    {
        Passport::actingAs($this->user);

        $visible = factory(Issue::class, 10)->create([
            'project_id' => $this->project->id
        ])->each(function (Issue $issue) {
            $this->user->allow('read', $issue);
        });

        factory(Issue::class, 10)->create([
            'project_id' => $this->project->id
        ]);


        $this->json('GET', $this->basePath)
            ->assertStatus(200)
            ->assertJsonCount($visible->count());
    }

    public function testStoreNeedsCreatePermission()
    {
        Passport::actingAs($this->user);

        $this->user->allow('create issue', $this->project);


        $this->json('POST', $this->basePath,[
            'name' => 'Lorem Iprum',
            'issue_state_id' => factory(IssueState::class)->create(['project_id' => $this->project->id])->id
        ])->assertStatus(201);

        $this->user->forbid('create issue', $this->project);
        Bouncer::refresh();

        $this->json('POST', $this->basePath,[
            'name' => 'dolor sit'
        ])->assertStatus(403);
    }

    public function testShowNeedsReadPermission()
    {
        Passport::actingAs($this->user);

        $issue = factory(Issue::class)->create([
            'project_id' => $this->project->id
        ]);

        $this->user->allow('read', $issue);

        $this->json('GET', $this->basePath . "/{$issue->id}")
            ->assertStatus(200);

        $this->user->forbid('read', $issue);
        Bouncer::refresh();

        $this->json('GET', $this->basePath . "/{$issue->id}")
            ->assertStatus(403);
    }

    public function testUpdateNeedsUpdatePermission()
    {
        Passport::actingAs($this->user);

        $issue = factory(Issue::class)->create([
            'project_id' => $this->project->id
        ]);

        $this->user->allow('update', $issue);

        $this->json('PUT', $this->basePath . "/{$issue->id}", ['name' => 'Lorem Ipsum'])
            ->assertStatus(200);

        $this->user->forbid('update', $issue);
        Bouncer::refresh();

        $this->json('PUT', $this->basePath . "/{$issue->id}", ['name' => 'dolor sit'])
            ->assertStatus(403);
    }

    public function testDestroyNeedsDeletePermission()
    {
        Passport::actingAs($this->user);

        $issue = factory(Issue::class)->create([
            'project_id' => $this->project->id
        ]);

        $this->user->allow('delete', $issue);

        $this->json('DELETE', $this->basePath . "/{$issue->id}")
            ->assertStatus(200);


        $issue = factory(Issue::class)->create([
            'project_id' => $this->project->id
        ]);

        $this->user->forbid('delete', $issue);

        $this->json('DELETE', $this->basePath . "/{$issue->id}")
            ->assertStatus(403);
    }
}
