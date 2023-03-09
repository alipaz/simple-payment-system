<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserAuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_register()
    {
        $data = [
            User::COLUMN_FIRST_NAME => 'John',
            User::COLUMN_LAST_NAME => 'Doe',
            User::COLUMN_EMAIL => 'john.doe@example.com',
            User::COLUMN_PASSWORD => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post(route('user.register'), $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            User::COLUMN_FIRST_NAME => 'John',
            User::COLUMN_LAST_NAME => 'Doe',
            User::COLUMN_EMAIL => 'john.doe@example.com',
        ]);
    }
}
