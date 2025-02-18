<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\SendMessageRequest;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    public function sendMessage(SendMessageRequest $request): JsonResponse
    {
        try {
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