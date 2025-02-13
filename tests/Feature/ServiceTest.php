<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Service;
use App\Models\CVInformation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;

class ServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private string $adminToken;
    private CVInformation $cvInformation;

    protected function setUp(): void
    {
        parent::setUp();
        
        $loginResponse = $this->postJson('/api/login', [
            'email' => config('admin.email'),
            'password' => config('admin.password')
        ]);

        $this->adminToken = $loginResponse->json('token');
        
        $this->cvInformation = CVInformation::factory()->create();
    }

    #[Test]
    public function anyone_can_list_services()
    {
        // Arrange
        $services = Service::factory()->count(3)->create([
            'name' => 'Web Geliştirme',
            'description' => 'Web uygulamaları geliştirme hizmeti',
            'icon' => 'fa-code',
            'cv_information_id' => $this->cvInformation->id
        ]);

        // Act
        $response = $this->getJson('/api/services');

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'icon',
                        'cv_information_id',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ])
            ->assertJsonCount(3, 'data')
            ->assertJson([
                'data' => [
                    [
                        'name' => 'Web Geliştirme',
                        'description' => 'Web uygulamaları geliştirme hizmeti',
                        'icon' => 'fa-code'
                    ]
                ]
            ]);
    }

    #[Test]
    public function anyone_can_show_service()
    {
        // Arrange
        $service = Service::factory()->create([
            'name' => 'API Geliştirme',
            'description' => 'RESTful API geliştirme hizmeti',
            'icon' => 'fa-plug',
            'cv_information_id' => $this->cvInformation->id
        ]);

        // Act
        $response = $this->getJson("/api/services/{$service->id}");

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'description',
                    'icon',
                    'cv_information_id',
                    'created_at',
                    'updated_at'
                ]
            ])
            ->assertJson([
                'data' => [
                    'name' => 'API Geliştirme',
                    'description' => 'RESTful API geliştirme hizmeti',
                    'icon' => 'fa-plug'
                ]
            ]);
    }

    #[Test]
    public function admin_can_create_service()
    {
        // Arrange
        $data = [
            'name' => 'Mobil Uygulama',
            'description' => 'Mobil uygulama geliştirme hizmeti',
            'icon' => 'fa-mobile',
            'cv_information_id' => $this->cvInformation->id
        ];

        // Act
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->adminToken}"
        ])->postJson('/api/services', $data);

        // Assert
        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Hizmet başarıyla oluşturuldu',
                'data' => [
                    'name' => 'Mobil Uygulama',
                    'description' => 'Mobil uygulama geliştirme hizmeti',
                    'icon' => 'fa-mobile'
                ]
            ]);

        $this->assertDatabaseHas('services', [
            'name' => 'Mobil Uygulama',
            'description' => 'Mobil uygulama geliştirme hizmeti',
            'icon' => 'fa-mobile',
            'cv_information_id' => $this->cvInformation->id
        ]);
    }

    #[Test]
    public function admin_can_update_service()
    {
        // Arrange
        $service = Service::factory()->create([
            'name' => 'Original Service',
            'description' => 'Original description',
            'icon' => 'fa-code',
            'cv_information_id' => $this->cvInformation->id
        ]);

        $data = [
            'name' => 'Updated Service',
            'description' => 'Updated description',
            'icon' => 'fa-paint-brush'
        ];

        // Act
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->adminToken}"
        ])->putJson("/api/services/{$service->id}", $data);

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Hizmet başarıyla güncellendi',
                'data' => [
                    'name' => 'Updated Service',
                    'description' => 'Updated description',
                    'icon' => 'fa-paint-brush'
                ]
            ]);

        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'name' => 'Updated Service',
            'description' => 'Updated description',
            'icon' => 'fa-paint-brush'
        ]);
    }

    #[Test]
    public function admin_can_delete_service()
    {
        // Arrange
        $service = Service::factory()->create([
            'cv_information_id' => $this->cvInformation->id
        ]);

        // Act
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->adminToken}"
        ])->deleteJson("/api/services/{$service->id}");

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Hizmet başarıyla silindi'
            ]);

        $this->assertSoftDeleted($service);
    }

    #[Test]
    public function unauthorized_users_cannot_create_service()
    {
        // Act
        $response = $this->postJson('/api/services', [
            'name' => 'Test Service'
        ]);

        // Assert
        $response->assertStatus(401);
    }

    #[Test]
    public function unauthorized_users_cannot_update_service()
    {
        // Arrange
        $service = Service::factory()->create([
            'cv_information_id' => $this->cvInformation->id
        ]);

        // Act
        $response = $this->putJson("/api/services/{$service->id}", [
            'name' => 'Updated Service'
        ]);

        // Assert
        $response->assertStatus(401);
    }

    #[Test]
    public function unauthorized_users_cannot_delete_service()
    {
        // Arrange
        $service = Service::factory()->create([
            'cv_information_id' => $this->cvInformation->id
        ]);

        // Act
        $response = $this->deleteJson("/api/services/{$service->id}");

        // Assert
        $response->assertStatus(401);
    }

    protected function tearDown(): void
    {
        cache()->forget('admin_token');
        parent::tearDown();
    }
} 