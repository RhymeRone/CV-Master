<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Portfolio;
use App\Models\CVInformation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;

class PortfolioTest extends TestCase
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
        
        Storage::fake('public');
    }

    #[Test]
    public function anyone_can_list_portfolios()
    {
        // Arrange
        Portfolio::factory()->count(3)->create([
            'name' => 'Test Project',
            'description' => 'Test Description',
            'link' => 'https://test.com',
            'image' => 'portfolio/images/test.jpg',
            'cv_information_id' => $this->cvInformation->id
        ]);

        // Act
        $response = $this->getJson('/api/portfolios');

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'link',
                        'image',
                        'cv_information_id',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ])
            ->assertJsonCount(3, 'data');
    }

    #[Test]
    public function anyone_can_show_portfolio()
    {
        // Arrange
        $portfolio = Portfolio::factory()->create([
            'name' => 'Single Project',
            'description' => 'Project Description',
            'link' => 'https://project.com',
            'image' => 'portfolio/images/project.jpg',
            'cv_information_id' => $this->cvInformation->id
        ]);

        // Act
        $response = $this->getJson("/api/portfolios/{$portfolio->id}");

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'Single Project',
                    'description' => 'Project Description',
                    'link' => 'https://project.com'
                ]
            ]);
    }

    #[Test]
    public function admin_can_create_portfolio()
    {
        // Arrange
        $image = UploadedFile::fake()->image('project.jpg')->size(1024);
        
        $data = [
            'name' => 'New Project',
            'description' => 'Project Description',
            'link' => 'https://newproject.com',
            'image' => $image,
            'cv_information_id' => $this->cvInformation->id
        ];

        // Act
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->adminToken}"
        ])->postJson('/api/portfolios', $data);

        // Assert
        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Portfolyo başarıyla oluşturuldu',
                'data' => [
                    'name' => 'New Project',
                    'description' => 'Project Description',
                    'link' => 'https://newproject.com'
                ]
            ]);

        $portfolio = Portfolio::first();
        $this->assertTrue(Storage::disk('public')->exists($portfolio->image));
    }

    #[Test]
    public function admin_can_update_portfolio()
    {
        // Arrange
        $portfolio = Portfolio::factory()->create([
            'name' => 'Old Project',
            'image' => 'portfolio/images/old.jpg',
            'cv_information_id' => $this->cvInformation->id
        ]);

        Storage::disk('public')->put('portfolio/images/old.jpg', 'old content');
        
        $newImage = UploadedFile::fake()->image('new.jpg')->size(1024);
        
        $data = [
            'name' => 'Updated Project',
            'description' => 'Updated Description',
            'image' => $newImage
        ];

        // Act
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->adminToken}"
        ])->putJson("/api/portfolios/{$portfolio->id}", $data);

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Portfolyo başarıyla güncellendi'
            ]);

        $this->assertFalse(Storage::disk('public')->exists('portfolio/images/old.jpg'));
        $this->assertTrue(Storage::disk('public')->exists($portfolio->fresh()->image));
    }

    #[Test]
    public function admin_can_delete_portfolio()
    {
        // Arrange
        $portfolio = Portfolio::factory()->create([
            'image' => 'portfolio/images/test.jpg',
            'cv_information_id' => $this->cvInformation->id
        ]);

        Storage::disk('public')->put('portfolio/images/test.jpg', 'test content');

        // Act
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->adminToken}"
        ])->deleteJson("/api/portfolios/{$portfolio->id}");

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Portfolyo başarıyla silindi'
            ]);

        $this->assertSoftDeleted($portfolio);
        $this->assertFalse(Storage::disk('public')->exists('portfolio/images/test.jpg'));
    }

    #[Test]
    public function unauthorized_users_cannot_create_portfolio()
    {
        // Act
        $response = $this->postJson('/api/portfolios', [
            'name' => 'Test Portfolio'
        ]);

        // Assert
        $response->assertStatus(401);
    }

    #[Test]
    public function unauthorized_users_cannot_update_portfolio()
    {
        // Arrange
        $portfolio = Portfolio::factory()->create([
            'cv_information_id' => $this->cvInformation->id
        ]);

        // Act
        $response = $this->putJson("/api/portfolios/{$portfolio->id}", [
            'name' => 'Updated Portfolio'
        ]);

        // Assert
        $response->assertStatus(401);
    }

    #[Test]
    public function unauthorized_users_cannot_delete_portfolio()
    {
        // Arrange
        $portfolio = Portfolio::factory()->create([
            'cv_information_id' => $this->cvInformation->id
        ]);

        // Act
        $response = $this->deleteJson("/api/portfolios/{$portfolio->id}");

        // Assert
        $response->assertStatus(401);
    }

    protected function tearDown(): void
    {
        cache()->forget('admin_token');
        parent::tearDown();
    }
} 