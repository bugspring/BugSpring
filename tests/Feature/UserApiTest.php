<?php

namespace Tests\Feature;

use App\Models\IssueState;
use App\Models\Project;
use App\Models\User;
use Bouncer;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use DatabaseTransactions;

    const BASE_PATH      = '/api/user';
    const JSON_STRUCTURE = [
        'id',
        'name',
        'email',
        'created_at',
        'updated_at',

        'projects' => [
            '*' => [
                'id',
                'owner_id',
                'name',
                'description',
                'created_at',
                'updated_at',
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

    public function testIndexReturnsAllUsers()
    {
        Passport::actingAs($this->user);

        $users = factory(User::class, 10)->create();

        dd($this->json('get',self::BASE_PATH)->getContent());
        $this->json('get', self::BASE_PATH)
            ->assertStatus(200)
            ->assertJsonStructure(self::JSON_STRUCTURE)
            ->assertJson($users->toArray());
    }

    public function testStoreReturnsMethodNotAllowed()
    {
        Passport::actingAs($this->user);

        $this->json('post', self::BASE_PATH)
            ->assertStatus(405);
    }

    public function testShowReturnsUser()
    {
        Passport::actingAs($this->user);

        /** @var User $user */
        $user = factory(User::class)->create();

        $this->json('get', self::BASE_PATH . "/{$user->id}")
            ->assertStatus(200)
            ->assertJson($user->toArray());
    }

    public function testUpdateCanChangeName()
    {
        Passport::actingAs($this->user);

        /** @var User $user */
        $user = factory(User::class)->create();


        $this->json('put',self::BASE_PATH . "/{$user->id}", ['name' => 'Lorem Ipsum'])
            ->assertStatus(201)
            ->assertJson(['name' => 'Lorem Ipsum']);

        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Lorem Ipsum']);
    }

    public function testUpdateCanChangeEmail()
    {
        Passport::actingAs($this->user);

        /** @var User $user */
        $user = factory(User::class)->create();


        $this->json('put', self::BASE_PATH . "/{$user->id}", ['name' => 'Lorem Ipsum'])
            ->assertStatus(201)
            ->assertJson(['name' => 'Lorem Ipsum']);

        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Lorem Ipsum']);
    }


    public function testDeleteReturnsProject()
    {
        Passport::actingAs($this->user);

        /** @var User $user */
        $user = factory(User::class)->create();

        $this->json('delete',self::BASE_PATH . "/{$user->id}")
            ->assertStatus(201)
            ->assertJson($user->toArray());
    }
}
