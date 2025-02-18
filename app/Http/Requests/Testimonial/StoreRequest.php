<?php

namespace App\Http\Requests\Testimonial;

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
            'comment' => 'required|string',
            'job' => 'required|string|max:255',
            'image' => 'required|image|mimes:'.implode(',', config('admin.upload.image.mimes')).'|max:'.config('admin.upload.image.max_size').'|min:'.config('admin.upload.image.min_size'),
            'cv_information_id' => 'required|exists:cv_information,id'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Referans adı gereklidir',
            'comment.required' => 'Referans yorumu gereklidir',
            'job.required' => 'Referans mesleği gereklidir',
            'image.required' => 'Referans fotoğrafı gereklidir',
            'image.image' => 'Dosya bir görsel olmalıdır',
            'image.mimes' => 'Görsel '.implode(',', config('admin.upload.image.mimes')).' formatında olmalıdır',
            'image.max' => 'Görsel en fazla '.config('admin.upload.image.max_size').'KB olabilir',
            'image.min' => 'Görsel en az '.config('admin.upload.image.min_size').'KB olmalıdır'
        ];
    }
} 