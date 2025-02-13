<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use PHPUnit\Framework\Attributes\Test;

class ContactTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
    }

    #[Test]
    public function anyone_can_send_contact_message()
    {
        // Arrange
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Test Subject',
            'message' => 'Test Message Content'
        ];

        // Act
        $response = $this->postJson('/api/contact', $data);

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Mesajınız başarıyla gönderildi'
            ]);

        Mail::assertQueued(ContactFormMail::class, function ($mail) use ($data) {
            return $mail->data['name'] === 'John Doe' &&
                   $mail->data['email'] === 'john@example.com' &&
                   $mail->data['subject'] === 'Test Subject' &&
                   $mail->data['message'] === 'Test Message Content';
        });
    }

    #[Test]
    public function contact_form_requires_valid_data()
    {
        // Act
        $response = $this->postJson('/api/contact', []);

        // Assert
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'subject', 'message']);
    }

    #[Test]
    public function contact_form_requires_valid_email()
    {
        // Arrange
        $data = [
            'name' => 'John Doe',
            'email' => 'invalid-email',
            'subject' => 'Test Subject',
            'message' => 'Test Message'
        ];

        // Act
        $response = $this->postJson('/api/contact', $data);

        // Assert
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    #[Test]
    public function contact_form_handles_mail_sending_error()
    {
        // Arrange
        Mail::shouldReceive('to->queue')
            ->once()
            ->andThrow(new \Exception('Failed to send mail'));

        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Test Subject',
            'message' => 'Test Message'
        ];

        // Act
        $response = $this->postJson('/api/contact', $data);

        // Assert
        $response->assertStatus(500)
            ->assertJson([
                'message' => 'Mesaj gönderilirken bir hata oluştu'
            ]);
    }
} 