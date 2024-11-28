<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateAccountTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_user_can_register_successfully()
    {
        $response = $this->postJson('/api/create-account', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'mobile_no' => '1234567890',
            'password' => 'password123',
            'address_1' => '123 Main St',
            'address_2' => 'Apt 101',
            'city' => 'New York',
            'state' => 'NY',
            'pincode' => '10001',
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'Account created successfully',
                 ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'mobile_no' => '1234567890',
        ]);

        $this->assertDatabaseHas('user_details', [
            'address_1' => '123 Main St',
            'city' => 'New York',
            'state' => 'NY',
        ]);
    }

    public function test_user_registration_fails_with_duplicate_email()
    {
        // Create a user with the same email
        User::factory()->create([
            'email' => 'john@example.com',
            'mobile_no' => '1234567890',
        ]);

        // Attempt to register with the same email
        $response = $this->postJson('/api/create-account', [
            'name' => 'Jane Doe',
            'email' => 'john@example.com', // Duplicate email
            'mobile_no' => '9876543210',
            'password' => 'password123',
            'address_1' => '456 Elm St',
            'address_2' => 'Apt 202',
            'city' => 'Los Angeles',
            'state' => 'CA',
            'pincode' => '90001',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    public function test_user_registration_fails_with_duplicate_mobile_no()
    {
        // Create a user with the same mobile number
        User::factory()->create([
            'email' => 'jane.doe@example.com',
            'mobile_no' => '1234567890',
        ]);

        // Attempt to register with the same mobile number
        $response = $this->postJson('/api/create-account', [
            'name' => 'John Smith',
            'email' => 'john.smith@example.com',
            'mobile_no' => '1234567890', // Duplicate mobile number
            'password' => 'password123',
            'address_1' => '789 Oak St',
            'address_2' => 'Apt 303',
            'city' => 'Chicago',
            'state' => 'IL',
            'pincode' => '60601',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['mobile_no']);
    }
}
