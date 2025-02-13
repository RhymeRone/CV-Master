<?php

namespace App\Http\Requests\PortfolioCategory;

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
            'icon' => 'sometimes|required|string|max:50',
            'cv_information_id' => 'sometimes|required|exists:cv_information,id'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Kategori adı gereklidir',
            'icon.required' => 'Kategori ikonu gereklidir',
            'icon.max' => 'İkon ismi çok uzun'
        ];
    }
} 