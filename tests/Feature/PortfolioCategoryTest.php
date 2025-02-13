<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\CVInformation;
use App\Models\PortfolioCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;

class PortfolioCategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $cv;
    private $adminToken;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Test CV'si oluştur
        $this->cv = CVInformation::factory()->create();
        
        // Admin token oluştur ve cache'e kaydet
        $this->adminToken = 'test_admin_token';
        cache()->put('admin_token', $this->adminToken, now()->addDay());
    }

    #[Test]
    public function can_list_all_portfolio_categories()
    {
        // Arrange
        PortfolioCategory::factory()->count(3)->create([
            'cv_information_id' => $this->cv->id
        ]);

        // Act
        $response = $this->getJson('/api/portfolio-categories');

        // Assert
        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'slug',
                        'icon',
                        'cv_information_id',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
    }

    #[Test]
    public function can_show_single_portfolio_category()
    {
        // Arrange
        $category = PortfolioCategory::factory()->create([
            'cv_information_id' => $this->cv->id
        ]);

        // Act
        $response = $this->getJson("/api/portfolio-categories/{$category->slug}");

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'icon' => $category->icon
                ]
            ]);
    }

    #[Test]
    public function can_create_portfolio_category_with_admin_token()
    {
        // Arrange
        $categoryData = [
            'name' => 'Test Category',
            'icon' => 'fa-test',
            'cv_information_id' => $this->cv->id
        ];

        // Act
        $response = $this->withHeader('Authorization', "Bearer {$this->adminToken}")
            ->postJson('/api/portfolio-categories', $categoryData);

        // Assert
        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => 'Test Category',
                    'icon' => 'fa-test',
                    'slug' => 'test-category'
                ]
            ]);

        $this->assertDatabaseHas('portfolio_categories', [
            'name' => 'Test Category',
            'icon' => 'fa-test'
        ]);
    }

    #[Test]
    public function cannot_create_portfolio_category_without_admin_token()
    {
        // Arrange
        $categoryData = [
            'name' => 'Test Category',
            'icon' => 'fa-test',
            'cv_information_id' => $this->cv->id
        ];

        // Act
        $response = $this->postJson('/api/portfolio-categories', $categoryData);

        // Assert
        $response->assertStatus(401);
    }

    #[Test]
    public function can_update_portfolio_category_with_admin_token()
    {
        // Arrange
        $category = PortfolioCategory::factory()->create([
            'cv_information_id' => $this->cv->id
        ]);

        $updateData = [
            'name' => 'Updated Category',
            'icon' => 'fa-updated'
        ];

        // Act
        $response = $this->withHeader('Authorization', "Bearer {$this->adminToken}")
            ->putJson("/api/portfolio-categories/{$category->slug}", $updateData);

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'Updated Category',
                    'icon' => 'fa-updated',
                    'slug' => 'updated-category'
                ]
            ]);
    }

    #[Test]
    public function can_delete_portfolio_category_with_admin_token()
    {
        // Arrange
        $category = PortfolioCategory::factory()->create([
            'cv_information_id' => $this->cv->id
        ]);

        // Act
        $response = $this->withHeader('Authorization', "Bearer {$this->adminToken}")
            ->deleteJson("/api/portfolio-categories/{$category->slug}");

        // Assert
        $response->assertStatus(200);
        $this->assertSoftDeleted('portfolio_categories', [
            'id' => $category->id
        ]);
    }

    #[Test]
    public function validates_required_fields_when_creating()
    {
        // Act
        $response = $this->withHeader('Authorization', "Bearer {$this->adminToken}")
            ->postJson('/api/portfolio-categories', []);

        // Assert
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'icon', 'cv_information_id']);
    }

    #[Test]
    public function generates_unique_slug_for_same_names()
    {
        // Arrange
        $categoryData = [
            'name' => 'Test Category',
            'icon' => 'fa-test',
            'cv_information_id' => $this->cv->id
        ];

        // Act - Create first category
        $this->withHeader('Authorization', "Bearer {$this->adminToken}")
            ->postJson('/api/portfolio-categories', $categoryData);

        // Create second category with same name
        $response = $this->withHeader('Authorization', "Bearer {$this->adminToken}")
            ->postJson('/api/portfolio-categories', $categoryData);

        // Assert
        $response->assertStatus(201);
        $this->assertDatabaseHas('portfolio_categories', [
            'name' => 'Test Category',
            'slug' => 'test-category-1'
        ]);
    }
} 