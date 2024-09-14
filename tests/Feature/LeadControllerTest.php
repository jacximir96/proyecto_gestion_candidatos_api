<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh --seed');

        $authResponse = $this->postJson('/auth', [
            'username' => 'tester',
            'password' => 'PASSWORD',
        ]);

        $authResponse->assertStatus(200);
        $this->token = $authResponse->json('data.token');
    }

    /**
     * Test para crear un candidato con éxito.
     *
     * @return void
     */
    public function testCreateLeadWithValidToken(): void
    {
        $leadData = [
            'name' => 'Mi candidato',
            'source' => 'Fotocasa',
            'owner' => 2,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/json',
        ])->postJson('/lead', $leadData);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'meta' => [
                'success',
                'errors',
            ],
            'data' => [
                'id',
                'name',
                'source',
                'owner',
                'created_at',
                'created_by',
            ],
        ]);

        $this->assertDatabaseHas('leads', [
            'name' => 'Mi candidato',
            'source' => 'Fotocasa',
            'owner' => 2,
        ]);
    }

    /**
     * Test para verificar que un token inválido o expirado devuelva 401 Unauthorized.
     *
     * @return void
     */
    public function testCreateLeadWithInvalidToken(): void
    {
        $invalidToken = 'invalid_or_expired_token';
    
        $leadData = [
            'name' => 'Mi candidato',
            'source' => 'Fotocasa',
            'owner' => 2,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $invalidToken,
            'Content-Type' => 'application/json',
        ])->postJson('/lead', $leadData);
    
        $response->assertStatus(401);
    
        $response->assertJson([
            'meta' => [
                'success' => false,
            ],
        ]);

        $response->assertJsonStructure([
            'meta' => [
                'success',
                'errors',
            ],
        ]);
    }

    /**
     * Test para verificar la obtencion de todos los candidatos con un token valido
     *
     * @return void
    */

    public function testGetAllLeadsWithValidToken(): void
    {
        $leads = \App\Domain\Models\Lead::factory()->count(5)->create();
    
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/leads');
    
        $response->assertStatus(200);
    
        $response->assertJsonStructure([
            'meta' => [
                'success',
                'errors',
            ],
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'source',
                    'owner',
                    'created_at',
                    'created_by',
                ]
            ],
        ]);

        $this->assertCount(5, $response->json('data'));
    }

    /**
     * Test para verificar la obtencion de todos los candidatos con un token invalido
     *
     * @return void
    */

    public function testGetAllLeadsWithInvalidToken(): void
    {
        $invalidToken = 'invalid_or_expired_token';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $invalidToken,
        ])->getJson('/leads');

        $response->assertStatus(401);

        $response->assertJson([
            'meta' => [
                'success' => false,
                'errors' => ['Token not provided or invalid'],
            ],
        ]);
    }

    /**
     * Test para verificar la obtencion del candidato por ID con un token valido
     *
     * @return void
    */

    public function testGetLeadByIdWithValidToken(): void
    {
        $lead = \App\Domain\Models\Lead::factory()->create([
            'name' => 'Lead de prueba',
            'source' => 'Fotocasa',
            'owner' => \App\Domain\Models\User::factory()->create()->id,
            'created_by' => \App\Domain\Models\User::factory()->create()->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson("/lead/{$lead->id}");

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'meta' => [
                'success',
                'errors',
            ],
            'data' => [
                'id',
                'name',
                'source',
                'owner',
                'created_at',
                'created_by',
            ],
        ]);

        $response->assertJson([
            'data' => [
                'id' => $lead->id,
                'name' => 'Lead de prueba',
                'source' => 'Fotocasa',
                'owner' => $lead->owner,
                'created_by' => $lead->created_by,
            ]
        ]);
    }

    /**
     * Test para verificar la obtencion del candidato por ID con un token invalido
     *
     * @return void
    */

    public function testGetLeadByIdWithInvalidToken(): void
    {
        $lead = \App\Domain\Models\Lead::factory()->create([
            'name' => 'Lead de prueba',
            'source' => 'Fotocasa',
            'owner' => \App\Domain\Models\User::factory()->create()->id,
            'created_by' => \App\Domain\Models\User::factory()->create()->id,
        ]);

        $invalidToken = 'invalid_or_expired_token';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $invalidToken,
        ])->getJson("/lead/{$lead->id}");

        $response->assertStatus(401);

        $response->assertJson([
            'meta' => [
                'success' => false,
                'errors' => ['Token not provided or invalid'],
            ],
        ]);
    }
}
