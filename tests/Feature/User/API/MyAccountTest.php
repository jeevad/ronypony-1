<?php

namespace Tests\Feature\User\API;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MyAccountTest extends TestCase
{
    use RefreshDatabase;

    protected $uri = '/api/profiles';
    protected $headers = [
        'Accept' => 'application/json,application/vnd.auth.api+json;version=1.0'
    ];

    /** @test */
    public function user_should_be_logged_in_to_update_password()
    {
        $this->postJson("{$this->uri}/password", $this->headers)
            ->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function only_authorized_users_can_update_their_password()
    {
        $this->postJson("{$this->uri}/password", $this->headers)
            ->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);

        $user = factory(User::class)->create();
        $this->apiAs($user, 'POST', "{$this->uri}/password", [
            'password' => '123456',
            'password_confirmation' => '123456',
            'current_password' => 'secret',
        ], $this->headers)
            ->assertSuccessful();
    }

    /** @test */
    public function users_can_login_with_updated_password()
    {
        // Create user
        $user = factory(User::class)->create();
        // Update password
        $this->apiAs($user, 'POST', "{$this->uri}/password", [
            'password' => '123456',
            'password_confirmation' => '123456',
            'current_password' => 'secret',
        ], $this->headers)
            ->assertSuccessful();

        // Login with old password
        $this->postJson('api/auth/login', [
            'email' => $user->email,
            'password' => 'secret',
        ], $this->headers)->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);

        // Login with updated password
        $response = $this->postJson('api/auth/login', [
            'email' => $user->email,
            'password' => '123456',
        ], $this->headers)->assertSuccessful()
            ->assertJsonStructure(['token_type', 'expires_in', 'access_token']);

        $this->assertNotEmpty($response->getOriginalContent()['access_token']);
    }

    /** @test */
    public function only_authorized_users_can_add_avatars()
    {
        $this->postJson("{$this->uri}/avatar", $this->headers)
            ->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function a_valid_avatar_must_be_provided()
    {
        $user = factory(User::class)->create();
        $this->apiAs($user, 'POST', "{$this->uri}/avatar", [
            'avatar' => 'not-an-image'
        ], $this->headers)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function a_user_may_add_an_avatar_to_their_profile()
    {
        Storage::fake('public');

        $user = factory(User::class)->create();
        $this->apiAs($user, 'POST', "{$this->uri}/avatar", [
            'avatar' => $avatar = UploadedFile::fake()->image('avatar.jpg')
        ], $this->headers)
            ->assertSuccessful();

        $user->refresh();
        Storage::disk('public')->assertExists("{$user->avatarFolder()}/{$user->avatar}");
    }

    /** @test */
    public function only_authorized_users_can_update_profile()
    {
        $this->putJson("{$this->uri}", $this->headers)
            ->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function authorized_users_can_update_profile()
    {
        // Create user
        $user = factory(User::class)->create();
        // Update profile
        $response = $this->apiAs($user, 'PUT', "{$this->uri}", [
            'full_name' => 'Nag',
            'email' => 'abc@gmail.com',
            'mobile_number' => '9845123845',
        ], $this->headers)
            ->assertSuccessful();

        $this->assertEquals($response->getOriginalContent()['full_name'], 'Nag');
        $this->assertEquals($response->getOriginalContent()['email'], 'abc@gmail.com');
        $this->assertEquals($response->getOriginalContent()['mobile_number'], '9845123845');
    }
}
