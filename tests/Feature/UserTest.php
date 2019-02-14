<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\App;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    public $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->artisan('passport:install');

    }

    /** @test */
    public function api_create_user()
    {

        $user = [
            'name' => 'Gerard',
            'email' => 'looh@out.com',
            'password' => 'Luna0102',
            'password_confirmation' => 'Luna0102'
        ];

        $this->json('POST', '/api/auth/signup', $user, ['Accept' => 'application/json'])
            ->assertStatus(201);


    }

    /** @test */
    public function api_login_user()
    {
        $user = [
            'email' => $this->user->email,
            'password' => 'secret',
            'remember_me' => true
        ];

        $this->json('post', '/api/auth/login', $user, ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

}
