<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class CVInformation extends Model
{
    /** @use HasFactory<\Database\Factories\CVInformationFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'cv_information';

    protected $fillable = [
        // Kişisel Bilgiler
        'name',
        'slogan',
        'birthday',
        'degree',
        
        // İletişim Bilgileri
        'email',
        'phone',
        'address',
        
        // Profesyonel Bilgiler
        'experience',
        'freelance',
        'clients',
        'projects',
        
        // Sosyal Medya Linkleri
        'linkedin',
        'github',
        'twitter',
        'facebook',
        'instagram',
        'website',
        
        // Medya Dosyaları
        'image',
        'cv_file',
    ];

    protected $casts = [
        'birthday' => 'date',
        'clients' => 'integer',
        'projects' => 'integer',
        'freelance' => 'string',
    ];

    // Slogan'ı array olarak almak için
    public function getSloganArrayAttribute()
    {
        return explode(',', $this->slogan);
    }

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    protected static function boot()
    {
        parent::boot();
        
        static::deleting(function ($cvInformation) {
            if ($cvInformation->image) {
                Storage::disk('public')->delete($cvInformation->image);
            }
            if ($cvInformation->cv_file) {
                Storage::disk('public')->delete($cvInformation->cv_file);
            }
        });
    }
}
