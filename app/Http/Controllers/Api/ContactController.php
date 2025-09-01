<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\SendMessageRequest;
use App\Mail\ContactFormMail;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    public function sendMessage(SendMessageRequest $request): JsonResponse
    {
        try {
            // Mesajı veritabanına kaydet
            Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // E-posta gönder
            Mail::to(config('admin.contact.email'))
                ->queue(new ContactFormMail($request->validated()));

            return response()->json([
                'message' => 'Mesajınız başarıyla gönderildi'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Mesaj gönderilirken bir hata oluştu'
            ], 500);
        }
    }
} 