<?php

namespace Tests\Feature;

use App\User;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{

    use WithFaker, RefreshDatabase;


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
            'name' => 'Gerard',
            'email' => 'looh@out.com',
            'password' => 'Luna0102',
            'password_confirmation' => 'Luna0102'
        ];

        $luser = [
            'email' => 'looh@out.com',
            'password' => 'Luna0102',
            'remember_me' => true
        ];

        $this->json('POST', '/api/auth/signup', $user, ['Accept' => 'application/json'])
            ->assertStatus(201);

        $this->artisan('passport:install');

        $this->json('post', '/api/auth/login', $luser, ['Accept' => 'application/json'])
            ->assertStatus(200);
    }

}
