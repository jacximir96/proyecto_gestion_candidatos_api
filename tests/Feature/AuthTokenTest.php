<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Domain\Models\User;

class AuthTokenTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh --seed');

        $this->user = User::factory()->create([
            'username' => 'testuser',
            'password' => bcrypt('password'),
            'role' => 'agent',
            'is_active' => true,
        ]);
    }

    /**
     * Test para verificar la generación de token.
     *
     * @return void
    */
    public function testTokenGeneration(): void
    {
        $response = $this->postJson('/auth', [
            'username' => $this->user->username,
            'password' => 'password',
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'meta' => [
                'success',
                'errors',
            ],
            'data' => [
                'token',
                'minutes_to_expire',
            ]
        ]);

        $response->assertJson([
            'meta' => ['success' => true, 'errors' => []],
        ]);
    }

    /**
     * Test para verificar que falle con credenciales incorrectas.
     *
     * @return void
    */
    public function testInvalidCredentials(): void
    {
        $response = $this->postJson('/auth', [
            'username' => $this->user->username,
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);

        $response->assertJsonStructure([
            'meta' => [
                'success',
                'errors',
            ]
        ]);

        $response->assertJson([
            'meta' => ['success' => false],
        ]);
    }
}
