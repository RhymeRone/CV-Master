<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Testimonial;
use App\Models\CVInformation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;

class TestimonialTest extends TestCase
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
    public function anyone_can_list_testimonials()
    {
        // Arrange
        Testimonial::factory()->count(3)->create([
            'name' => 'John Doe',
            'comment' => 'Great work!',
            'job' => 'CEO',
            'image' => 'testimonial/images/test.jpg',
            'cv_information_id' => $this->cvInformation->id
        ]);

        // Act
        $response = $this->getJson('/api/testimonials');

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'comment',
                        'job',
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
    public function anyone_can_show_testimonial()
    {
        // Arrange
        $testimonial = Testimonial::factory()->create([
            'name' => 'Jane Doe',
            'comment' => 'Excellent service!',
            'job' => 'CTO',
            'image' => 'testimonial/images/test.jpg',
            'cv_information_id' => $this->cvInformation->id
        ]);

        // Act
        $response = $this->getJson("/api/testimonials/{$testimonial->id}");

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'Jane Doe',
                    'comment' => 'Excellent service!',
                    'job' => 'CTO'
                ]
            ]);
    }

    #[Test]
    public function admin_can_create_testimonial()
    {
        // Arrange
        $image = UploadedFile::fake()->image('avatar.jpg')->size(1024);
        
        $data = [
            'name' => 'New Client',
            'comment' => 'Amazing experience!',
            'job' => 'Product Manager',
            'image' => $image,
            'cv_information_id' => $this->cvInformation->id
        ];

        // Act
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->adminToken}"
        ])->postJson('/api/testimonials', $data);

        // Assert
        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Referans başarıyla oluşturuldu',
                'data' => [
                    'name' => 'New Client',
                    'comment' => 'Amazing experience!',
                    'job' => 'Product Manager'
                ]
            ]);

        $testimonial = Testimonial::first();
        $this->assertTrue(Storage::disk('public')->exists($testimonial->image));
    }

    #[Test]
    public function admin_can_update_testimonial()
    {
        // Arrange
        $testimonial = Testimonial::factory()->create([
            'name' => 'Old Client',
            'image' => 'testimonial/images/old.jpg',
            'cv_information_id' => $this->cvInformation->id
        ]);

        Storage::disk('public')->put('testimonial/images/old.jpg', 'old content');
        
        $newImage = UploadedFile::fake()->image('new.jpg')->size(1024);
        
        $data = [
            'name' => 'Updated Client',
            'comment' => 'Updated comment',
            'image' => $newImage
        ];

        // Act
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->adminToken}"
        ])->putJson("/api/testimonials/{$testimonial->id}", $data);

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Referans başarıyla güncellendi'
            ]);

        $this->assertFalse(Storage::disk('public')->exists('testimonial/images/old.jpg'));
        $this->assertTrue(Storage::disk('public')->exists($testimonial->fresh()->image));
    }

    #[Test]
    public function admin_can_delete_testimonial()
    {
        // Arrange
        $testimonial = Testimonial::factory()->create([
            'image' => 'testimonial/images/test.jpg',
            'cv_information_id' => $this->cvInformation->id
        ]);

        Storage::disk('public')->put('testimonial/images/test.jpg', 'test content');

        // Act
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->adminToken}"
        ])->deleteJson("/api/testimonials/{$testimonial->id}");

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Referans başarıyla silindi'
            ]);

        $this->assertSoftDeleted($testimonial);
        $this->assertFalse(Storage::disk('public')->exists('testimonial/images/test.jpg'));
    }

    #[Test]
    public function unauthorized_users_cannot_create_testimonial()
    {
        // Act
        $response = $this->postJson('/api/testimonials', [
            'name' => 'Test Testimonial'
        ]);

        // Assert
        $response->assertStatus(401);
    }

    #[Test]
    public function unauthorized_users_cannot_update_testimonial()
    {
        // Arrange
        $testimonial = Testimonial::factory()->create([
            'cv_information_id' => $this->cvInformation->id
        ]);

        // Act
        $response = $this->putJson("/api/testimonials/{$testimonial->id}", [
            'name' => 'Updated Testimonial'
        ]);

        // Assert
        $response->assertStatus(401);
    }

    #[Test]
    public function unauthorized_users_cannot_delete_testimonial()
    {
        // Arrange
        $testimonial = Testimonial::factory()->create([
            'cv_information_id' => $this->cvInformation->id
        ]);

        // Act
        $response = $this->deleteJson("/api/testimonials/{$testimonial->id}");

        // Assert
        $response->assertStatus(401);
    }

    protected function tearDown(): void
    {
        cache()->forget('admin_token');
        parent::tearDown();
    }
} 