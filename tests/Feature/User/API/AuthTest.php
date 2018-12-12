<?php

namespace Tests\Feature\User\API;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected $uri = '/api/auth';
    protected $headers = [
        'Accept' => 'application/json,application/vnd.auth.api+json;version=1.0'
    ];

    /** @test */
    public function users_can_login_with_email_and_password()
    {
        $user = factory(User::class)->create();
        $response = $this->postJson($this->uri . '/login', [
            'email' => $user->email,
            'password' => env('SEEDER_USER_PASSWORD', 'secret'),
        ], $this->headers)->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure(['token_type', 'expires_in', 'access_token']);

        $responseData = (array)json_decode($response->content());
        $this->assertNotEmpty($responseData['access_token']);
    }

    /** @test */
    function guests_may_not_view_any_profile()
    {
        $user = factory(User::class)->create(['role_id' => 1]);
        $this->getJson("api/profiles/{$user->id}", $this->headers)
            ->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
    }

    /** @test */
    function an_authenticated_user_can_view_own_profile()
    {
        $user = factory(User::class)->create();
        $this->apiAs($user, 'GET', "{$this->uri}/me", [], $this->headers)
            ->assertSuccessful()
            ->assertJsonFragment([
                'id' => $user->id,
                'full_name' => $user->full_name,
                'email' => $user->email,
            ]);
    }

    /** @test */
    public function users_can_request_refresh_token_using_existing_token()
    {
        $user = factory(User::class)->create();
        $response = $this->apiAs($user, 'POST', "{$this->uri}/refresh", [], $this->headers)
            ->assertSuccessful()
            ->assertJsonStructure(['token_type', 'expires_in', 'access_token']);

        $this->assertNotEmpty($response->getOriginalContent()['access_token']);
    }

    /** @test */
    public function an_authenticated_user_can_logout()
    {
        $user = factory(User::class)->create();
        $this->apiAs($user, 'POST', "{$this->uri}/logout", [], $this->headers)
            ->assertSuccessful();
    }
}
