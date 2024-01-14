<?php

namespace Tests\Unit\V1\Controllers;

use App\Enums\Routes\V1\RouteEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected bool $refreshDatabase = true;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_login()
    {
        $password = 'testTest';

        $user = User::factory()->admin()->create([
            'password' => Hash::make($password)
        ]);

        $response = $this->post(route(RouteEnum::LOGIN->value), [
            'email' => $user->email,
            'password' => $password
        ]);

        $json = $response->json();
        $response->assertSuccessful()
            ->assertStatus(201);

        $this->assertArrayHasKey('access_token', $json);
        $this->assertArrayHasKey('token_type', $json);
    }

    public function test_login_user_not_found()
    {
        $password = 'testTest';

        $user = User::factory()->admin()->create([
            'password' => Hash::make($password)
        ]);

        $response = $this->post(route(RouteEnum::LOGIN->value), [
            'email' => $user->email,
            'password' => 'heheheheheh'
        ]);

        $response->assertStatus(401)
            ->assertJson([
                "message" => __('messages.api.auth.invalid_credentials'),
                "errors" => []
            ]);
    }

    public function test_login_validation_error()
    {
        $password = 'testTest';

        $user = User::factory()->admin()->create([
            'password' => Hash::make($password)
        ]);

        $response = $this->post('/api/v1/login?lang=sr_Latin', [
            'email' => $user->email,
            'password' => ''
        ], ['Accept' => 'application/json']);

        $response->assertStatus(422)
            ->assertJson([
                "message" => str_replace(':attribute', 'password', __('validation.required')),
                "errors" => [
                    "password" => [str_replace(':attribute', 'password', __('validation.required'))],
                ]
            ]);
    }

}
