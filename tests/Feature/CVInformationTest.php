<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\CVInformation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;

class CVInformationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private string $adminToken;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Admin token oluştur
        $loginResponse = $this->postJson('/api/login', [
            'email' => config('admin.email'),
            'password' => config('admin.password')
        ]);

        $this->adminToken = $loginResponse->json('token');
        
        // Storage'ı hazırla
        Storage::fake('public');
        
        // Test için gerekli dizinleri oluştur
        Storage::disk('public')->makeDirectory('cv/images');
        Storage::disk('public')->makeDirectory('cv/files');
        
        // Örnek dosyaları oluştur
        Storage::disk('public')->put('cv/images/default-avatar.jpg', 'test image content');
        Storage::disk('public')->put('cv/files/default-cv.pdf', 'test cv content');
    }

    #[Test]
    public function anyone_can_list_cv_information()
    {
        // Arrange
        $cv = CVInformation::factory()->create();

        // Act
        $response = $this->getJson('/api/cv-information');

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'slogan',
                        'birthday',
                        'degree',
                        'email',
                        'phone',
                        'address',
                        'experience',
                        'freelance',
                        'clients',
                        'projects',
                        'social_media' => [
                            'linkedin',
                            'github',
                            'twitter',
                            'facebook',
                            'instagram',
                            'website'
                        ],
                        'image',
                        'cv_file',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
    }

    #[Test]
    public function anyone_can_show_cv_information()
    {
        // Arrange
        $cv = CVInformation::factory()->create([
            'name' => 'Test Name',
            'slogan' => 'Test Slogan',
            'email' => 'test@example.com'
        ]);

        // Act
        $response = $this->getJson("/api/cv-information/{$cv->id}");

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'slogan',
                    'email'
                ]
            ]);
    }

    #[Test]
    public function admin_can_create_cv_information()
    {
        // Arrange
        Storage::fake('public');

        $image = UploadedFile::fake()->image('avatar.jpg')->size(20);
        $cvFile = UploadedFile::fake()->create('document.pdf', 20);

        $data = [
            'full_name' => $this->faker->name,
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->paragraph,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'image' => $image,
            'cv_file' => $cvFile
        ];

        // Act
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->adminToken}"
        ])->postJson('/api/cv-information', $data);

        // Assert
        $response->assertStatus(201)
            ->assertJson([
                'message' => 'CV bilgileri başarıyla oluşturuldu'
            ]);

        // Dosyaların yüklendiğini kontrol et
        $cv = CVInformation::first();
        $this->assertTrue(Storage::disk('public')->exists($cv->image));
        $this->assertTrue(Storage::disk('public')->exists($cv->cv_file));
    }

    #[Test]
    public function admin_can_update_cv_information()
    {
        // Arrange
        Storage::fake('public');
        
        // Factory ile model oluştur ve verileri kontrol et
        $cv = CVInformation::factory()->create([
            'name' => 'Original Name',
            'email' => 'original@email.com'
        ]);
        
        // Model'in oluştuğunu kontrol et
        $this->assertDatabaseHas('cv_information', [
            'id' => $cv->id,
            'name' => 'Original Name',
            'email' => 'original@email.com'
        ]);

        $data = [
            'name' => 'Updated Name',
            'email' => 'updated@email.com'
        ];

        // Act
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->adminToken}"
        ])->putJson("/api/cv-information/{$cv->id}", $data);

        // Assert
        $response->assertStatus(200);
        
        // Model'i yeniden yükle
        $updatedCv = CVInformation::find($cv->id);
        
        // Güncellenen verileri kontrol et
        $this->assertEquals('Updated Name', $updatedCv->name);
        $this->assertEquals('updated@email.com', $updatedCv->email);
    }

    #[Test]
    public function admin_can_delete_cv_information()
    {
        // Arrange
        Storage::fake('public');
        $cv = CVInformation::factory()->create([
            'image' => 'cv/images/test.jpg',
            'cv_file' => 'cv/files/test.pdf'
        ]);

        // Test dosyalarını oluştur
        Storage::disk('public')->put('cv/images/test.jpg', 'test content');
        Storage::disk('public')->put('cv/files/test.pdf', 'test content');

        // Dosyaların var olduğunu kontrol et
        $this->assertTrue(Storage::disk('public')->exists('cv/images/test.jpg'));
        $this->assertTrue(Storage::disk('public')->exists('cv/files/test.pdf'));

        // Act
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->adminToken}"
        ])->deleteJson("/api/cv-information/{$cv->id}");

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'CV bilgileri başarıyla silindi'
            ]);

        $this->assertSoftDeleted($cv);
        
        // Dosyaların silindiğini kontrol et
        $this->assertFalse(Storage::disk('public')->exists('cv/images/test.jpg'));
        $this->assertFalse(Storage::disk('public')->exists('cv/files/test.pdf'));
    }

    #[Test]
    public function unauthorized_users_cannot_create_cv_information()
    {
        // Act
        $response = $this->postJson('/api/cv-information', [
            'full_name' => $this->faker->name
        ]);

        // Assert
        $response->assertStatus(401);
    }

    #[Test]
    public function unauthorized_users_cannot_update_cv_information()
    {
        // Arrange
        $cv = CVInformation::factory()->create();

        // Act
        $response = $this->putJson("/api/cv-information/{$cv->id}", [
            'full_name' => 'Updated Name'
        ]);

        // Assert
        $response->assertStatus(401);
    }

    #[Test]
    public function unauthorized_users_cannot_delete_cv_information()
    {
        // Arrange
        $cv = CVInformation::factory()->create();

        // Act
        $response = $this->deleteJson("/api/cv-information/{$cv->id}");

        // Assert
        $response->assertStatus(401);
    }

    protected function tearDown(): void
    {
        // Her testten sonra cache'i temizle
        cache()->forget('admin_token');
        parent::tearDown();
    }
} 