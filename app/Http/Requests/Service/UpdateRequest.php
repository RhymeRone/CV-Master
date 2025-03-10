<?php

namespace App\Http\Requests\Service;

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
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'icon' => 'sometimes|required|string|max:50'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Hizmet adı gereklidir',
            'description.required' => 'Hizmet açıklaması gereklidir',
            'icon.required' => 'Hizmet ikonu gereklidir',
            'icon.max' => 'İkon ismi çok uzun'
        ];
    }
} 