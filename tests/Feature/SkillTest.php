<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Skill;
use App\Models\CVInformation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;

class SkillTest extends TestCase
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
        
        // Test için CV oluştur
        $this->cvInformation = CVInformation::factory()->create();
    }

    #[Test]
    public function anyone_can_list_skills()
    {
        // Arrange
        $skills = Skill::factory()->count(3)->create([
            'name' => 'Test Skill',
            'level' => 85,
            'color' => '#FF5733',
            'cv_information_id' => $this->cvInformation->id
        ]);

        // Act
        $response = $this->getJson('/api/skills');

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'level',
                        'color',
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
                        'name' => 'Test Skill',
                        'level' => 85,
                        'color' => '#FF5733'
                    ]
                ]
            ]);
    }

    #[Test]
    public function anyone_can_show_skill()
    {
        // Arrange
        $skill = Skill::factory()->create([
            'name' => 'PHP',
            'level' => 90,
            'color' => '#4C5270',
            'cv_information_id' => $this->cvInformation->id
        ]);

        // Act
        $response = $this->getJson("/api/skills/{$skill->id}");

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'level',
                    'color',
                    'cv_information_id',
                    'created_at',
                    'updated_at'
                ]
            ])
            ->assertJson([
                'data' => [
                    'name' => 'PHP',
                    'level' => 90,
                    'color' => '#4C5270'
                ]
            ]);
    }

    #[Test]
    public function admin_can_create_skill()
    {
        // Arrange
        $data = [
            'name' => 'Laravel',
            'level' => 95,
            'color' => '#FF5733',
            'cv_information_id' => $this->cvInformation->id
        ];

        // Act
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->adminToken}"
        ])->postJson('/api/skills', $data);

        // Assert
        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Yetenek başarıyla oluşturuldu',
                'data' => [
                    'name' => 'Laravel',
                    'level' => 95,
                    'color' => '#FF5733'
                ]
            ]);

        $this->assertDatabaseHas('skills', [
            'name' => 'Laravel',
            'level' => 95,
            'color' => '#FF5733',
            'cv_information_id' => $this->cvInformation->id
        ]);
    }

    #[Test]
    public function admin_can_update_skill()
    {
        // Arrange
        $skill = Skill::factory()->create([
            'name' => 'Original Skill',
            'level' => 80,
            'color' => '#4C5270',
            'cv_information_id' => $this->cvInformation->id
        ]);

        $data = [
            'name' => 'Updated Skill',
            'level' => 85,
            'color' => '#FF5733'
        ];

        // Act
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->adminToken}"
        ])->putJson("/api/skills/{$skill->id}", $data);

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Yetenek başarıyla güncellendi',
                'data' => [
                    'name' => 'Updated Skill',
                    'level' => 85,
                    'color' => '#FF5733'
                ]
            ]);

        $this->assertDatabaseHas('skills', [
            'id' => $skill->id,
            'name' => 'Updated Skill',
            'level' => 85,
            'color' => '#FF5733'
        ]);
    }

    #[Test]
    public function admin_can_delete_skill()
    {
        // Arrange
        $skill = Skill::factory()->create([
            'cv_information_id' => $this->cvInformation->id
        ]);

        // Act
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->adminToken}"
        ])->deleteJson("/api/skills/{$skill->id}");

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Yetenek başarıyla silindi'
            ]);

        $this->assertSoftDeleted($skill);
    }

    #[Test]
    public function unauthorized_users_cannot_create_skill()
    {
        // Act
        $response = $this->postJson('/api/skills', [
            'name' => 'Test Skill'
        ]);

        // Assert
        $response->assertStatus(401);
    }

    #[Test]
    public function unauthorized_users_cannot_update_skill()
    {
        // Arrange
        $skill = Skill::factory()->create([
            'cv_information_id' => $this->cvInformation->id
        ]);

        // Act
        $response = $this->putJson("/api/skills/{$skill->id}", [
            'name' => 'Updated Skill'
        ]);

        // Assert
        $response->assertStatus(401);
    }

    #[Test]
    public function unauthorized_users_cannot_delete_skill()
    {
        // Arrange
        $skill = Skill::factory()->create([
            'cv_information_id' => $this->cvInformation->id
        ]);

        // Act
        $response = $this->deleteJson("/api/skills/{$skill->id}");

        // Assert
        $response->assertStatus(401);
    }

    protected function tearDown(): void
    {
        cache()->forget('admin_token');
        parent::tearDown();
    }
} 