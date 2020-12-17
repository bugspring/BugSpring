<?php

namespace Tests\Feature;

use App\Models\IssueState;
use App\Models\Project;
use App\Models\User;
use Bouncer;
use Firebase\JWT\JWT;
use Illuminate\Encryption\Encrypter;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Passport\Passport;
use Laravel\Passport\Token;
use League\Flysystem\Config;
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

        factory(User::class, 10)->create();
        $users = User::all();
        $this->json('get', self::BASE_PATH)
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => self::JSON_STRUCTURE
            ])
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

    public function testShowCanReturnSession()
    {
        $this->disableCookieEncryption();
        Passport::actingAs($this->user);

        /** @var Encrypter $encrypter */
        $encrypter = app(Encrypter::class);

        $cookies = [Passport::cookie() => encrypt('33685b41dbc47dbe410bb1fc96e1e58a114c529c|' . JWT::encode([
                "sub"    => 1,
                "csrf"   => "nTk6cA8fgvw0lklXwkSxS3ELcSbY2imfczVNRa2R",
                "expiry" => 1607202264
            ], $encrypter->getKey()))];

        $this->call('GET', self::BASE_PATH . '/session', [], $cookies)
            ->assertStatus(200)
            ->assertJson([
                "user"    => [
                    'id'    => $this->user->id,
                    'name'  => $this->user->name,
                    'email' => $this->user->email
                ],
                "expiry" => "1607202264"
            ]);

    }

    public function testUpdateCanChangeName()
    {
        Passport::actingAs($this->user);

        /** @var User $user */
        $user = factory(User::class)->create();


        $this->json('put', self::BASE_PATH . "/{$user->id}", ['name' => 'Lorem Ipsum'])
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

        $this->json('delete', self::BASE_PATH . "/{$user->id}")
            ->assertStatus(201)
            ->assertJson($user->toArray());
    }
}
