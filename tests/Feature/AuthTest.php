<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\Attributes\Test;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    private string $validEmail;
    private string $validPassword;

    protected function setUp(): void
    {
        parent::setUp();

        // Config'den geçerli admin bilgilerini al
        $this->validEmail = config('admin.email');
        $this->validPassword = config('admin.password');

        // Token lifetime'ı integer olarak ayarla
        config(['admin.token_lifetime' => (int)config('admin.token_lifetime')]);
    }

    #[Test]
    public function can_login_with_valid_credentials()
    {
        $response = $this->postJson('/api/login', [
            'email' => $this->validEmail,
            'password' => $this->validPassword
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'token',
                'type',
                'expires_in'
            ]);

        // Token'ın cache'e kaydedildiğini kontrol et
        $token = $response->json('token');
        $this->assertTrue(Cache::has('admin_token'));
        $this->assertEquals($token, Cache::get('admin_token'));
    }

    #[Test]
    public function cannot_login_with_invalid_credentials()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'wrong@email.com',
            'password' => 'wrong_password'
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Yetkisiz erişim'
            ]);
    }

    #[Test]
    public function cannot_login_with_missing_credentials()
    {
        $response = $this->postJson('/api/login', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'password']);
    }

    #[Test]
    public function can_logout_with_valid_token()
    {
        // Önce login ol ve token al
        $loginResponse = $this->postJson('/api/login', [
            'email' => $this->validEmail,
            'password' => $this->validPassword
        ]);

        $token = $loginResponse->json('token');
        
        // Token'ı cache'e kaydet (AuthController'daki gibi)
        cache(['admin_token' => $token], now()->addSeconds(config('admin.token_lifetime')));

        // Token ile logout ol
        $response = $this->withHeaders([
            'Authorization' => "Bearer {$token}",
            'Accept' => 'application/json'
        ])->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Başarıyla çıkış yapıldı'
            ]);

        // Token'ın cache'den silindiğini kontrol et
        $this->assertFalse(Cache::has('admin_token'));
    }

    #[Test]
    public function cannot_logout_without_token()
    {
        $response = $this->postJson('/api/logout');

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }

    #[Test]
    public function cannot_logout_with_invalid_token()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer invalid_token',
            'Accept' => 'application/json'
        ])->postJson('/api/logout');

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }

    #[Test]
    public function cannot_login_while_already_logged_in()
    {
        // İlk login işlemi
        $firstLoginResponse = $this->postJson('/api/login', [
            'email' => $this->validEmail,
            'password' => $this->validPassword
        ]);

        $token = $firstLoginResponse->json('token');
        $this->assertTrue(Cache::has('admin_token'));

        // İkinci login denemesi
        $secondLoginResponse = $this->withHeaders([
            'Authorization' => "Bearer {$token}",
            'Accept' => 'application/json'
        ])->postJson('/api/login', [
            'email' => $this->validEmail,
            'password' => $this->validPassword
        ]);

        $secondLoginResponse->assertStatus(400)
            ->assertJson([
                'message' => 'Zaten giriş yapılmış'
            ]);
    }

    protected function tearDown(): void
    {
        // Her testten sonra cache'i temizle
        Cache::forget('admin_token');
        parent::tearDown();
    }
} 