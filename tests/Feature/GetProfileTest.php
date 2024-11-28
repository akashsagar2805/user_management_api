<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_get_profile()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        UserDetail::factory()->create([
            'user_id' => $user->id,
            'address_1' => '123 Main St',
            'address_2' => 'Apt 101',
            'city' => 'New York',
            'state' => 'NY',
            'pincode' => '10001',
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/get-profile');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'name',
                    'email',
                    'mobile_no',
                    'status',
                    'details' => [
                        'address_1',
                        'address_2',
                        'city',
                        'state',
                        'pincode',
                    ],
                ],
            ]);
    }

    public function test_unauthenticated_user_cannot_get_profile()
    {
        $response = $this->getJson('/api/get-profile');

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }
}
