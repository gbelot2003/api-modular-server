<?php

namespace Tests\Feature;

use App\User;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PassportAuthTest extends TestCase
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


    /** @test */
    public function api_return_user()
    {
        Passport::actingAs(
            factory(User::class)->create());

        $this->json('get', '/api/auth/user')
            ->assertStatus(200);
    }

    /** @test */
    public function apt_logout_compleate()
    {
        Passport::actingAs(
          factory(User::class)->create());

        $this->json('get', '/api/auth/logout')
            ->assertStatus(200)
            ->assertJsonFragment(['message' => 'Successfully logged out']);

    }
}
