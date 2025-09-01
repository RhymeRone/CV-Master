<?php

namespace App\Console\Commands;

use App\Models\Contact;
use App\Mail\ContactFormMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class CreateFakeMessageCommand extends Command
{
    protected $signature = 'message:fake {--name=} {--email=} {--subject=} {--message=}';
    protected $description = 'Yapay test mesajı oluştur ve gönder';

    public function handle()
    {
        $name = $this->option('name') ?: $this->ask('Gönderen adı?');
        $email = $this->option('email') ?: $this->ask('Gönderen email adresi?');
        $subject = $this->option('subject') ?: $this->ask('Mesaj konusu?');
        $message = $this->option('message') ?: $this->ask('Mesaj içeriği?');
        
        // Doğrulama
        $validator = Validator::make([
            'name' => $name,
            'email' => $email, 
            'subject' => $subject,
            'message' => $message
        ], [
            'name' => 'required|string|min:2',
            'email' => 'required|email',
            'subject' => 'required|string|min:3',
            'message' => 'required|string|min:10'
        ]);
        
        if ($validator->fails()) {
            $this->error($validator->errors()->first());
            return 1;
        }
        
        try {
            // Yapay IP ve User Agent oluştur
            $ipAddress = '127.0.0.1';
            $userAgent = 'CLI/Artisan Fake Message Generator';
            
            // Mesajı veritabanına kaydet
            $contact = Contact::create([
                'name' => $name,
                'email' => $email,
                'subject' => $subject,
                'message' => $message,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent
            ]);
            
            // E-posta gönder
            $data = [
                'name' => $name,
                'email' => $email,
                'subject' => $subject,
                'message' => $message
            ];
            
            Mail::to(config('admin.contact.email'))
                ->queue(new ContactFormMail($data));
                
            $this->info("Mesaj başarıyla oluşturuldu ve gönderildi:");
            $this->table(
                ['ID', 'Gönderen', 'E-posta', 'Konu'], 
                [[$contact->id, $contact->name, $contact->email, $contact->subject]]
            );
            
            return 0;
        } catch (\Exception $e) {
            $this->error("Mesaj oluşturulurken bir hata oluştu: " . $e->getMessage());
            return 1;
        }
    }
} 