<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Mockery\Generator\StringManipulation\Pass\Pass;
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
        'updated_at'
    ];

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
    public function testIndexReturnsAllOwnedAndLinkedProjects()
    {
        Passport::actingAs($this->user);
        $otherUser = factory(User::class)->create();

        factory(Project::class, 50)->create([
            'owner_id' => $this->user->id
        ]);

        factory(Project::class, 50)->create([
            'owner_id' => $otherUser->id
        ])->each(function($project){
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

        $this->json('POST', self::BASE_PATH,$projectData)
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


}
