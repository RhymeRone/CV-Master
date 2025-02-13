<?php

namespace App\Http\Requests\Portfolio;

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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|url|max:255',
            'image' => 'required|image|mimes:'.implode(',', config('admin.upload.image.mimes')).'|max:'.config('admin.upload.image.max_size').'|min:'.config('admin.upload.image.min_size'),
            'cv_information_id' => 'required|exists:cv_information,id'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Portfolyo adı gereklidir',
            'link.url' => 'Geçerli bir URL giriniz',
            'image.required' => 'Portfolyo görseli gereklidir',
            'image.image' => 'Dosya bir görsel olmalıdır',
            'image.mimes' => 'Görsel '.implode(',', config('admin.upload.image.mimes')).' formatında olmalıdır',
            'image.max' => 'Görsel en fazla '.config('admin.upload.image.max_size').'KB olabilir',
            'image.min' => 'Görsel en az '.config('admin.upload.image.min_size').'KB olmalıdır'
        ];
    }
} 