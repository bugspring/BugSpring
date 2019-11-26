<?php

namespace Tests\Feature;

use Bouncer;
use App\Models\Issue;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class IssueApiTest extends TestCase
{
    use DatabaseTransactions;

    const BASE_PATH = '/api/project/%d/issue';
    const JSON_STRUCTURE = [
        'id',
        'name',
        'project_id',
        'created_at',
        'updated_at'
    ];

    private $basePath;

    /** @var User $user */
    private $user;

    /** @var Project $project */
    private $project;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        Bouncer::allow($this->user)->everything();

        $this->project = factory(Project::class)->create([
            'owner_id' => $this->user->id,
        ]);

        $this->basePath = sprintf(self::BASE_PATH, $this->project->id);
    }


    public function testIndexListsAllIssuesOfAProject()
    {
        Passport::actingAs($this->user);
        $otherUser = factory(User::class)->create();
        $otherProject = factory(Project::class)->create([
            'owner_id' => $otherUser->id
        ]);

        $issues = factory(Issue::class, 50)->create([
            'project_id' => $this->project->id
        ]);

        factory(Issue::class, 50)->create([
            'project_id' => $otherProject->id
        ]);

        $this->json('GET', $this->basePath)
            ->assertStatus(200)
            ->assertJsonStructure(['*' => self::JSON_STRUCTURE])
            ->assertJsonCount($issues->count());
    }

    public function testStoreCreatesAIssueInTheDatabase()
    {
        Passport::actingAs($this->user);

        $issueData = [
            'name' => 'Submitting a form drops the database...',
        ];

        $this->json('POST', $this->basePath, $issueData)
            ->assertStatus(201)
            ->assertJsonStructure(self::JSON_STRUCTURE)
            ->assertJson($issueData);

        $this->assertDatabaseHas('issues', $issueData);
    }

    public function testStoreNeedsNameProperty()
    {
        Passport::actingAs($this->user);

        $this->json('POST', $this->basePath, [])
            ->assertStatus(422);
    }

    public function testShowReturnsOneIssue()
    {
        Passport::actingAs($this->user);

        $issue = factory(Issue::class)->create([
            'project_id' => $this->project->id
        ]);

        $this->json('GET', $this->basePath . "/{$issue->id}")
            ->assertStatus(200)
            ->assertJsonStructure(self::JSON_STRUCTURE)
            ->assertJson($issue->toArray());
    }

    public function testShowOnlyReturnsIssuesWhichExistInReferencedProject()
    {
        Passport::actingAs($this->user);

        $issue = factory(Issue::class)->create([
            'project_id' => (factory(Project::class)->create([
                'owner_id' => (factory(User::class)->create())->id
            ]))->id
        ]);

        $this->json('GET', $this->basePath . "/{$issue->id}")
            ->assertStatus(404);

    }
}
