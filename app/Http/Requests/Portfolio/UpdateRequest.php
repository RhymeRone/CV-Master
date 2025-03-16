<?php

namespace App\Http\Requests\Portfolio;

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
            'description' => 'nullable|string',
            'link' => 'nullable|url|max:255',
            'images' => 'sometimes|array',
            'images.*' => 'required|image|mimes:' . implode(',', config('admin.upload.image.mimes')) . '|max:' . config('admin.upload.image.max_size') . '|min:' . config('admin.upload.image.min_size'),
            'categories' => 'required|array|min:1',
            'categories.*' => 'required|exists:portfolio_categories,id'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Portfolyo adı gereklidir',
            'link.url' => 'Geçerli bir URL giriniz',
            'images.array' => 'Görseller dizi formatında olmalıdır',
            'images.*.required' => 'Görsel gereklidir',
            'images.*.image' => 'Dosya bir görsel olmalıdır',
            'images.*.mimes' => 'Görsel ' . implode(',', config('admin.upload.image.mimes')) . ' formatında olmalıdır',
            'images.*.max' => 'Görsel en fazla ' . config('admin.upload.image.max_size') . 'KB olabilir',
            'images.*.min' => 'Görsel en az ' . config('admin.upload.image.min_size') . 'KB olmalıdır',
            'categories.required' => 'En az bir kategori seçmelisiniz',
            'categories.array' => 'Kategoriler dizi formatında olmalıdır',
            'categories.min' => 'En az bir kategori seçmelisiniz',
            'categories.*.required' => 'Kategori gereklidir',
            'categories.*.exists' => 'Seçilen kategori sistemde bulunamadı'
        ];
    }
}