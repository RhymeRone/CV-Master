<?php

namespace App\Http\Requests\Experience;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'position' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'start_date' => 'required|date|before:end_date|after:1900-01-01',
            'end_date' => 'nullable|date|after:start_date|before:'.date('Y-m-d', strtotime('+1 year')),
        ];
    }

    public function messages(): array
    {
        return [
            'position.required' => 'Pozisyon adı gereklidir',
            'company.required' => 'Şirket adı gereklidir',
            'start_date.required' => 'Başlangıç tarihi gereklidir',
            'start_date.date' => 'Başlangıç tarihi tarih formatında olmalıdır',
            'start_date.before' => 'Başlangıç tarihi bitiş tarihinden önce olmalıdır',
            'start_date.after' => 'Başlangıç tarihi 1900\'den küçük olamaz',
            'end_date.date' => 'Bitiş tarihi tarih formatında olmalıdır',
            'end_date.after' => 'Bitiş tarihi başlangıç tarihinden sonra olmalıdır',
            'end_date.before' => 'Bitiş tarihi gelecek yıldan büyük olamaz',
            'end_date.gte' => 'Bitiş tarihi başlangıç tarihinden küçük olamaz'
        ];
    }
} 