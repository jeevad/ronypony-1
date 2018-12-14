<?php

namespace Tests\Feature\User\API;

use Tests\TestCase;
use App\Models\User;
use App\Models\State;
use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddressTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $uri = '/api/addresses';
    protected $headers = [
        'Accept' => 'application/json,application/vnd.auth.api+json;version=1.0'
    ];

    /** @test */
    public function guests_may_not_add_address()
    {
        $this->postJson("{$this->uri}", $this->headers)
            ->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
    }

    /** @test */
    function authorized_users_can_add_new_address()
    {
        $user = factory(User::class)->create();
        $fakeData = $this->prepareAddressData();
        $response = $this->apiAs($user, 'POST', $this->uri, $fakeData, $this->headers)
            ->assertStatus(JsonResponse::HTTP_CREATED);
        $responseData = $response->getOriginalContent();

        $this->assertEquals($responseData['address'], $fakeData['address']);
        $this->assertTrue($responseData['default']);
    }

    /** @test */
    function authorized_users_can_update_existing_address()
    {
        $user = factory(User::class)->create();
        $address = factory(Address::class)->create(['user_id' => $user->id]);
        $fakeData = $this->prepareAddressData();
        $response = $this->apiAs($user, 'PUT', "{$this->uri}/{$address->id}", $fakeData, $this->headers)
            ->assertSuccessful();

        $responseData = $response->getOriginalContent();

        $this->assertEquals($responseData['address'], $fakeData['address']);
    }

    /** @test */
    function users_not_allowed_to_delete_default_address()
    {
        $user = factory(User::class)->create();
        $address = factory(Address::class)->state('default')->create(['user_id' => $user->id]);
        $fakeData = $this->prepareAddressData();
        $this->apiAs($user, 'DELETE', "{$this->uri}/{$address->id}", $fakeData, $this->headers)
            ->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    /** @test */
    function users_are_allowed_to_delete_address_which_is_not_default()
    {
        $user = factory(User::class)->create();
        $defaultAddress = factory(Address::class)->state('default')->create([
            'user_id' => $user->id,
        ]);
        $this->apiAs($user, 'DELETE', "{$this->uri}/{$defaultAddress->id}", [], $this->headers)
            ->assertStatus(JsonResponse::HTTP_BAD_REQUEST);

        $anoterhAddress = factory(Address::class)->create(['user_id' => $user->id]);
        $this->apiAs($user, 'DELETE', "{$this->uri}/{$anoterhAddress->id}", [], $this->headers)
            ->assertSuccessful();
    }

    /** @test */
    function users_are_allowed_to_mark_address_as_default()
    {
        $user = factory(User::class)->create();
        $address1 = factory(Address::class)->state('default')->create([
            'user_id' => $user->id,
        ]);
        $address2 = factory(Address::class)->create([
            'user_id' => $user->id,
        ]);
        $this->apiAs($user, 'PATCH', "{$this->uri}/{$address2->id}/mark-default", [], $this->headers)
            ->assertSuccessful();

        $address1 = Address::find($address1->id);
        $address2 = Address::find($address2->id);

        $this->assertTrue($address2->default);
        $this->assertFalse($address1->default);
    }

    protected function prepareAddressData($overrides = [])
    {
        $state = factory(State::class)->create();
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'office_name' => $this->faker->company,
            'locality' => $this->faker->address,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'state_id' => $state->id,
            'country_id' => $state->country_id,
            'zip_code' => str_repeat('1', 6),
        ];

        return array_merge($data, $overrides);
    }
}
