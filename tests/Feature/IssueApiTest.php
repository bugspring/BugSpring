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
use Mockery\Generator\StringManipulation\Pass\Pass;
use Tests\TestCase;

class IssueApiTest extends TestCase
{
    use DatabaseTransactions;

    const BASE_PATH = '/api/project/%d/issue';
    const JSON_STRUCTURE = [
        'id',
        'name',
        'issue_state',
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
            'issue_state_id' => factory(IssueState::class)->create(['project_id' => $this->project->id])->id
        ];

        $this->json('POST', $this->basePath, $issueData)
            ->assertStatus(201)
            ->assertJsonStructure(self::JSON_STRUCTURE)
            ->assertJson([
                'name' => $issueData['name'],
                'issue_state' => IssueState::find($issueData['issue_state_id'])->toArray()
            ]);

        $this->assertDatabaseHas('issues', $issueData);
    }

    public function testStoreNeedsNameProperty()
    {
        Passport::actingAs($this->user);

        $issueData = [
            'issue_state_id' => factory(IssueState::class)->create(['project_id' => $this->project->id])->id
        ];

        $this->json('POST', $this->basePath, $issueData)
            ->assertStatus(422);
    }

    public function testStoreNeedsIssueStateIdProperty()
    {
        Passport::actingAs($this->user);

        $issueData = [
            'name' => 'Submitting a form drops the database...',
        ];

        $this->json('POST', $this->basePath, $issueData)
            ->assertStatus(422);
    }

    public function testStoreIssueStateIdMustExistInDatabase()
    {
        Passport::actingAs($this->user);

        $issueStateId = 1;
        while (IssueState::whereId($issueStateId)->exists()) {
            $issueStateId += 1;
        }

        $issueData = [
            'name' => 'Creating an issue make users want to cry',
            'issue_state_id' => $issueStateId,
        ];

        $this->json('POST', $this->basePath, $issueData)
            ->assertStatus(422);
    }

    public function testStoreIssueStateMustExistInSameProjectAsIssue()
    {
        Passport::actingAs($this->user);

        $unattachedProject = factory(Project::class)->create();

        $issueData = [
            'name' => 'Issues can have states from unattached projects',
            'issue_state_id' => factory(IssueState::class)->create(['project_id' => $unattachedProject->id])->id
        ];

        $this->json('POST', $this->basePath, $issueData)
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

    public function testUpdateModifiesAIssueInTheDatabase()
    {
        Passport::actingAs($this->user);

        $issue = factory(Issue::class)->create([
            'project_id' => $this->project->id
        ]);

        $updateData = [
            'name' => 'Dropping databases makes users mad...',
            'issue_state_id' => factory(IssueState::class)->create(['project_id' => $this->project->id])->id
        ];

        $this->json('PUT', $this->basePath . "/{$issue->id}", $updateData)
            ->assertStatus(200)
            ->assertJsonStructure(self::JSON_STRUCTURE)
            ->assertJson([
                'name' => $updateData['name'],
                'issue_state' => IssueState::find($updateData['issue_state_id'])->toArray()
            ]);

        $this->assertDatabaseHas('issues', $updateData);
    }

    public function testUpdateIssueMustExistInReferencedProject()
    {
        Passport::actingAs($this->user);

        $issue = factory(Issue::class)->create([
            'project_id' => (factory(Project::class)->create([
                'owner_id' => (factory(User::class)->create())->id
            ]))->id
        ]);

        $updateData = [
            'name' => 'Mad users make a magnificent mob'
        ];

        $this->json('PUT', $this->basePath . "/{$issue->id}", $updateData)
            ->assertStatus(404);
    }

    public function testUpdateIssueStateIdMustExistInDatabase()
    {
        Passport::actingAs($this->user);

        $issue = factory(Issue::class)->create([
            'project_id' => (factory(Project::class)->create([
                'owner_id' => (factory(User::class)->create())->id
            ]))->id
        ]);

        $issueStateId = 1;
        while (IssueState::whereId($issueStateId)->exists()) {
            $issueStateId += 1;
        }

        $issueData = [
            'issue_state_id' => $issueStateId,
        ];

        $this->json('PUT', $this->basePath . "/{$issue->id}", $issueData)
            ->assertStatus(422);
    }

    public function testUpdateIssueStateMustExistInSameProjectAsIssue()
    {
        Passport::actingAs($this->user);

        $unattachedProject = factory(Project::class)->create();

        $issue = factory(Issue::class)->create([
            'project_id' => $this->project->id
        ]);

        $issueData = [
            'name' => 'Issues can have states from unattached projects',
            'issue_state_id' => factory(IssueState::class)->create(['project_id' => $unattachedProject->id])->id
        ];

        $this->json('PUT', $this->basePath . "/{$issue->id}", $issueData)
            ->assertStatus(422);
    }

    public function testDestroyDeletesTheIssueInTheDatabase()
    {
        Passport::actingAs($this->user);

        $issue = factory(Issue::class)->create([
            'project_id' => $this->project->id
        ]);

        $this->json('DELETE', $this->basePath . "/{$issue->id}")
            ->assertStatus(200)
            ->assertJsonStructure(self::JSON_STRUCTURE)
            ->assertJson($issue->toArray());

        $this->assertDatabaseMissing('issues', $issue->toArray());

    }

    public function testDestroyIssueMustExistInReferencedProject()
    {
        Passport::actingAs($this->user);

        $issue = factory(Issue::class)->create([
            'project_id' => (factory(Project::class)->create([
                'owner_id' => (factory(User::class)->create())->id
            ]))->id
        ]);

        $this->json('DELETE', $this->basePath . "/{$issue->id}")
            ->assertStatus(404);
    }

}
