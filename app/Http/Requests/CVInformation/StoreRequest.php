<?php

namespace App\Http\Requests\CVInformation;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Policy zaten kontrol ediyor
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'slogan' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
            'degree' => 'nullable|string|max:255',
            'email' => 'required|email|unique:cv_information,email',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'experience' => 'nullable|string',
            'freelance' => 'nullable|in:available,unavailable',
            'clients' => 'nullable|integer|min:0',
            'projects' => 'nullable|integer|min:0',
            'linkedin' => 'nullable|url|max:255',
            'github' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'website' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:'.implode(',', config('admin.upload.image.mimes')).'|max:'.config('admin.upload.image.max_size').'|min:'.config('admin.upload.image.min_size'),
            'cv_file' => 'nullable|file|mimes:'.implode(',', config('admin.upload.cv.mimes')).'|max:'.config('admin.upload.cv.max_size'),
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'E-posta adresi gereklidir',
            'email.email' => 'Geçerli bir e-posta adresi giriniz',
            'email.unique' => 'Bu e-posta adresi zaten kullanılmakta',
            
            'name.string' => 'İsim metin formatında olmalıdır',
            'name.max' => 'İsim en fazla 255 karakter olabilir',
            
            'slogan.string' => 'Slogan metin formatında olmalıdır',
            'slogan.max' => 'Slogan en fazla 255 karakter olabilir',
            
            'birthday.date' => 'Geçerli bir tarih giriniz',
            
            'degree.string' => 'Derece metin formatında olmalıdır',
            'degree.max' => 'Derece en fazla 255 karakter olabilir',
            
            'phone.string' => 'Telefon metin formatında olmalıdır',
            'phone.max' => 'Telefon en fazla 255 karakter olabilir',
            
            'address.string' => 'Adres metin formatında olmalıdır',
            
            'experience.string' => 'Deneyim metin formatında olmalıdır',
            
            'freelance.in' => 'Serbest çalışma durumu available veya unavailable olmalıdır',
            
            'clients.integer' => 'Müşteri sayısı tam sayı olmalıdır',
            'clients.min' => 'Müşteri sayısı en az 0 olmalıdır',
            
            'projects.integer' => 'Proje sayısı tam sayı olmalıdır',
            'projects.min' => 'Proje sayısı en az 0 olmalıdır',
            
            'linkedin.url' => 'Geçerli bir LinkedIn URL\'si giriniz',
            'linkedin.max' => 'LinkedIn URL\'si en fazla 255 karakter olabilir',
            
            'github.url' => 'Geçerli bir GitHub URL\'si giriniz',
            'github.max' => 'GitHub URL\'si en fazla 255 karakter olabilir',
            
            'twitter.url' => 'Geçerli bir Twitter URL\'si giriniz',
            'twitter.max' => 'Twitter URL\'si en fazla 255 karakter olabilir',
            
            'facebook.url' => 'Geçerli bir Facebook URL\'si giriniz',
            'facebook.max' => 'Facebook URL\'si en fazla 255 karakter olabilir',
            
            'instagram.url' => 'Geçerli bir Instagram URL\'si giriniz',
            'instagram.max' => 'Instagram URL\'si en fazla 255 karakter olabilir',
            
            'website.url' => 'Geçerli bir website URL\'si giriniz',
            'website.max' => 'Website URL\'si en fazla 255 karakter olabilir',
            
            'image.image' => 'Dosya bir resim olmalıdır',
            'image.max' => 'Resim dosyası en fazla '.config('admin.upload.image.max_size').'KB olabilir',
            'image.min' => 'Resim dosyası en az '.config('admin.upload.image.min_size').'KB olmalıdır',
            'image.mimes' => 'Resim dosyası '.implode(',', config('admin.upload.image.mimes')).' formatında olmalıdır',
            
            'cv_file.file' => 'CV bir dosya olmalıdır',
            'cv_file.mimes' => 'CV dosyası '.implode(',', config('admin.upload.cv.mimes')).' formatında olmalıdır',
            'cv_file.max' => 'CV dosyası en fazla '.config('admin.upload.cv.max_size').'KB olabilir',
        ];
    }
}
