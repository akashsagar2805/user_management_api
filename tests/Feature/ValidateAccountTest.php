<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ValidateAccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_validate_account_successfully()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/validate-account', [
            'user_id' => $user->id,
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'message',
                     'data' => ['token'],
                 ]);
    }

    public function test_user_validation_fails_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/validate-account', [
            'user_id' => $user->id,
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                     'status' => 'error',
                     'message' => 'Invalid credentials',
                 ]);
    }
}
