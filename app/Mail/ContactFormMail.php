<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('İletişim Formu: ' . $this->data['subject'])
                    ->locale('tr')
                    ->view('vendor.mail.html.message')
                    ->with([
                        'level' => 'success',
                        'greeting' => 'Yeni İletişim Formu Mesajı',
                        'introLines' => [
                            'Gönderen: ' . $this->data['name'],
                            'E-posta: ' . $this->data['email'],
                            'Konu: ' . $this->data['subject'],
                            'Mesaj:',
                            $this->data['message']
                        ],
                        'outroLines' => [
                            'Bu e-posta iletişim formundan otomatik olarak gönderilmiştir.'
                        ],
                        'actionText' => 'Yanıtla',
                        'actionUrl' => 'mailto:' . $this->data['email'],
                    ]);
    }
} 