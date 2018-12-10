<?php

namespace Tests\Feature\User\API;

use Tests\TestCase;
use App\Events\UserRegistered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistarationTest extends TestCase
{
    use RefreshDatabase;

    protected $uri = '/api/profiles/';
    protected $headers = [
        'Accept' => 'application/json,application/vnd.auth.api+json;version=1.0'
    ];

    public function setUp()
    {
        parent::setUp();
        $this->test_data = [
            'full_name' => 'Ronypony',
            'email' => env('SEEDER_USER_EMAIL', 'nag.samayam@email.com'),
            'password' => env('SEEDER_USER_PASSWORD', 'secret'),
            'password_confirmation' => env('SEEDER_USER_PASSWORD', 'secert'),
        ];
    }

    /** @test */
    public function a_user_requires_email()
    {
        unset($this->test_data['email']);

        $this->_prepare_user_registration_response()
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['email']);

    }

    /** @test */
    public function a_user_requires_valid_email()
    {
        $this->_prepare_user_registration_response(['email' => 'abc'])
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['email']);

    }

    /** @test */
    function email_validation_should_reject_invalid_email_addresses()
    {
        collect(['abc', 'test@gmail', 'hello.gmail.com'])->each(function ($invalidEmail) {
            $this->_prepare_user_registration_response(['email' => $invalidEmail])
                ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
                ->assertJsonValidationErrors(['email']);
        });
    }

    /** @test */
    function email_should_not_be_too_long()
    {
        $this->_prepare_user_registration_response([
            'email' => str_repeat('a', 247) . '@test.com', // 256
        ])->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function full_name_should_not_be_too_long()
    {
        $this->_prepare_user_registration_response(['full_name' => str_repeat('a', 61),])
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['full_name']);
    }

    /** @test */
    public function a_user_requires_password()
    {
        unset($this->test_data['password']);

        $this->_prepare_user_registration_response()
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['password']);

    }

    /** @test */
    public function password_should_not_be_too_long()
    {
        $password = str_repeat('a', 21);
        $this->_prepare_user_registration_response([
            'password' => $password,
            'password_confirmation' => $password,
        ])->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['password']);
    }

    /** @test */
    public function password_should_not_be_too_short()
    {
        $password = str_repeat('a', 5);
        $this->_prepare_user_registration_response([
            'password' => $password,
            'password_confirmation' => $password,
        ])->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['password']);
    }

    /** @test */
    public function password_and_confirm_password_should_match()
    {
        $password = str_repeat('a', 5);
        $this->_prepare_user_registration_response([
            'password' => $password,
        ])->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['password']);
    }

    /** @test */
    public function users_email_should_be_unique()
    {
        $this->_prepare_user_registration_response()
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure(['token_type', 'expires_in', 'access_token']);

        $this->assertDatabaseHas('users', [
            'email' => $this->test_data['email'],
        ]);

        $this->_prepare_user_registration_response()
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function user_can_register_with_email()
    {
        $response = $this->_prepare_user_registration_response()
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure(['token_type', 'expires_in', 'access_token']);

        $this->assertDatabaseHas('users', [
            'email' => $this->test_data['email'],
        ]);

        $responseData = (array)json_decode($response->content());
        $this->assertNotEmpty($responseData['access_token']);
    }

    /** @test */
    public function a_confirmation_email_is_sent_upon_email_registration()
    {
        Event::fake();

        $this->_prepare_user_registration_response()
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure(['token_type', 'expires_in', 'access_token']);

        Event::assertDispatched(UserRegistered::class);
    }

    private function _prepare_user_registration_response($overriders = [])
    {
        $this->test_data = array_merge($this->test_data, $overriders);

        return $this->postJson($this->uri, $this->test_data, $this->headers);
    }
}
