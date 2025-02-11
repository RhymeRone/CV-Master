<?php

namespace App\Http\Requests\Skill;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'level' => 'sometimes|required|integer|min:0|max:100',
            'color' => 'sometimes|required|string|size:7|starts_with:#',
            'cv_information_id' => 'sometimes|required|exists:cv_information,id'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Yetenek adı gereklidir',
            'level.required' => 'Seviye gereklidir',
            'level.integer' => 'Seviye sayı olmalıdır',
            'level.min' => 'Seviye en az 0 olmalıdır',
            'level.max' => 'Seviye en fazla 100 olmalıdır',
            'color.required' => 'Renk gereklidir',
            'color.size' => 'Renk kodu 7 karakter olmalıdır (örn: #FF0000)',
            'color.starts_with' => 'Renk kodu # ile başlamalıdır'
        ];
    }
}
