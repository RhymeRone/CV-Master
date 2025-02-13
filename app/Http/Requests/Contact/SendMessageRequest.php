<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class SendMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Herkes mesaj gönderebilir
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'İsim alanı gereklidir',
            'email.required' => 'E-posta alanı gereklidir',
            'email.email' => 'Geçerli bir e-posta adresi giriniz',
            'subject.required' => 'Konu alanı gereklidir',
            'message.required' => 'Mesaj alanı gereklidir'
        ];
    }
} 