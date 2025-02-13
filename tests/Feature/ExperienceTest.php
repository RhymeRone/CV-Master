<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Experience;
use App\Models\CVInformation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;

class ExperienceTest extends TestCase
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
    public function anyone_can_list_experiences()
    {
        // Arrange
        $experiences = Experience::factory()->count(3)->create([
            'position' => 'Software Developer',
            'company' => 'Tech Corp',
            'start_year' => 2020,
            'end_year' => 2023,
            'cv_information_id' => $this->cvInformation->id
        ]);

        // Act
        $response = $this->getJson('/api/experiences');

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'position',
                        'company',
                        'start_year',
                        'end_year',
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
                        'position' => 'Software Developer',
                        'company' => 'Tech Corp',
                        'start_year' => 2020,
                        'end_year' => 2023
                    ]
                ]
            ]);
    }

    #[Test]
    public function anyone_can_show_experience()
    {
        // Arrange
        $experience = Experience::factory()->create([
            'position' => 'Senior Developer',
            'company' => 'Google',
            'start_year' => 2019,
            'end_year' => null,
            'cv_information_id' => $this->cvInformation->id
        ]);

        // Act
        $response = $this->getJson("/api/experiences/{$experience->id}");

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'position',
                    'company',
                    'start_year',
                    'end_year',
                    'cv_information_id',
                    'created_at',
                    'updated_at'
                ]
            ])
            ->assertJson([
                'data' => [
                    'position' => 'Senior Developer',
                    'company' => 'Google',
                    'start_year' => 2019,
                    'end_year' => null
                ]
            ]);
    }

    #[Test]
    public function admin_can_create_experience()
    {
        // Arrange
        $data = [
            'position' => 'Full Stack Developer',
            'company' => 'Facebook',
            'start_year' => 2021,
            'end_year' => 2023,
            'cv_information_id' => $this->cvInformation->id
        ];

        // Act
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->adminToken}"
        ])->postJson('/api/experiences', $data);

        // Assert
        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Deneyim başarıyla oluşturuldu',
                'data' => [
                    'position' => 'Full Stack Developer',
                    'company' => 'Facebook',
                    'start_year' => 2021,
                    'end_year' => 2023
                ]
            ]);

        $this->assertDatabaseHas('experiences', [
            'position' => 'Full Stack Developer',
            'company' => 'Facebook',
            'start_year' => 2021,
            'end_year' => 2023,
            'cv_information_id' => $this->cvInformation->id
        ]);
    }

    #[Test]
    public function admin_can_update_experience()
    {
        // Arrange
        $experience = Experience::factory()->create([
            'position' => 'Junior Developer',
            'company' => 'Startup Inc',
            'start_year' => 2018,
            'end_year' => 2020,
            'cv_information_id' => $this->cvInformation->id
        ]);

        $data = [
            'position' => 'Senior Developer',
            'company' => 'Enterprise Corp',
            'start_year' => 2020,
            'end_year' => null
        ];

        // Act
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->adminToken}"
        ])->putJson("/api/experiences/{$experience->id}", $data);

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Deneyim başarıyla güncellendi',
                'data' => [
                    'position' => 'Senior Developer',
                    'company' => 'Enterprise Corp',
                    'start_year' => 2020,
                    'end_year' => null
                ]
            ]);

        $this->assertDatabaseHas('experiences', [
            'id' => $experience->id,
            'position' => 'Senior Developer',
            'company' => 'Enterprise Corp',
            'start_year' => 2020,
            'end_year' => null
        ]);
    }

    #[Test]
    public function admin_can_delete_experience()
    {
        // Arrange
        $experience = Experience::factory()->create([
            'cv_information_id' => $this->cvInformation->id
        ]);

        // Act
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->adminToken}"
        ])->deleteJson("/api/experiences/{$experience->id}");

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Deneyim başarıyla silindi'
            ]);

        $this->assertSoftDeleted($experience);
    }

    #[Test]
    public function unauthorized_users_cannot_create_experience()
    {
        // Act
        $response = $this->postJson('/api/experiences', [
            'position' => 'Test Position'
        ]);

        // Assert
        $response->assertStatus(401);
    }

    #[Test]
    public function unauthorized_users_cannot_update_experience()
    {
        // Arrange
        $experience = Experience::factory()->create([
            'cv_information_id' => $this->cvInformation->id
        ]);

        // Act
        $response = $this->putJson("/api/experiences/{$experience->id}", [
            'position' => 'Updated Position'
        ]);

        // Assert
        $response->assertStatus(401);
    }

    #[Test]
    public function unauthorized_users_cannot_delete_experience()
    {
        // Arrange
        $experience = Experience::factory()->create([
            'cv_information_id' => $this->cvInformation->id
        ]);

        // Act
        $response = $this->deleteJson("/api/experiences/{$experience->id}");

        // Assert
        $response->assertStatus(401);
    }

    protected function tearDown(): void
    {
        cache()->forget('admin_token');
        parent::tearDown();
    }
} 