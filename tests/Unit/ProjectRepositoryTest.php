<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Repositories\ProjectRepository;
use http\Client\Curl\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectRepositoryTest extends TestCase
{
    /** @var ProjectRepository $projectRepository */
    private $projectRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->projectRepository = new ProjectRepository();
    }


    public function testReturnsProjectsOfUser()
    {
        $user = factory(User::class)->create();
        $otheruser = factory(User::class)->create();
        $projects = factory(Project::class, 10)->create([
            'owner_id' => $user->id
        ]);
        factory(Project::class)->create([
            'owner_id' => $otheruser->id
        ]);

        $this->assertTrue(false);

    }
}
