<?php

namespace App\Http\Requests\Experience;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'position' => 'sometimes|required|string|max:255',
            'company' => 'sometimes|required|string|max:255',
            'start_year' => 'sometimes|required|integer|min:1900|max:'.(date('Y')+1),
            'end_year' => 'nullable|integer|min:1900|max:'.(date('Y')+1).'|gte:start_year',
            'cv_information_id' => 'sometimes|required|exists:cv_information,id'
        ];
    }

    public function messages(): array
    {
        return [
            'position.required' => 'Pozisyon adı gereklidir',
            'company.required' => 'Şirket adı gereklidir',
            'start_year.required' => 'Başlangıç yılı gereklidir',
            'start_year.integer' => 'Başlangıç yılı sayı olmalıdır',
            'start_year.min' => 'Başlangıç yılı 1900\'den küçük olamaz',
            'start_year.max' => 'Başlangıç yılı gelecek yıldan büyük olamaz',
            'end_year.integer' => 'Bitiş yılı sayı olmalıdır',
            'end_year.min' => 'Bitiş yılı 1900\'den küçük olamaz',
            'end_year.max' => 'Bitiş yılı gelecek yıldan büyük olamaz',
            'end_year.gte' => 'Bitiş yılı başlangıç yılından küçük olamaz'
        ];
    }
} 