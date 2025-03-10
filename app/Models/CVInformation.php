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
        'position',
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

        // Aktiflik Durumu
        'is_active',
    ];

    protected $casts = [
        'birthday' => 'date',
        'clients' => 'integer',
        'projects' => 'integer',
        'freelance' => 'string',
        'is_active' => 'boolean',
    ];

    // Slogan'ı array olarak almak için
    public function getSloganArrayAttribute()
    {
        return explode(',', $this->slogan);
    }

    // CVInformation.php içinde, diğer metotların yanına

    // Birthday için mutator
    public function setBirthdayAttribute($value)
    {
        $this->attributes['birthday'] = $value ? date('Y-m-d', strtotime($value)) : null;
    }
    public function getBirthdayAttribute($value)
    {
        return $value ? date('Y-m-d', strtotime($value)) : null;
    }

    // ----------------------------------- Componentler için -----------------------------------
    public function assignments()
    {
        return $this->hasMany(CVAssignment::class, 'cv_information_id');
    }

    public function getComponent($type)
    {
        return $this->assignments()
            ->where('assignable_type', $type)
            ->orderBy('order')
            ->get()
            ->map(function ($assignment) {
                return $assignment->assignable;
            });
    }
    public function getComponents()
    {
        return $this->assignments()
            ->orderBy('order')
            ->get()
            ->map(function ($assignment) {
                return $assignment->assignable;
            });
    }
    public function setComponent($type, $data)
    {
        $this->assignments()->create([
            'assignable_type' => $type,
            'assignable_id' => $data->id,
        ]);
    }
    public function deleteComponent($type)
    {
        $this->assignments()->where('assignable_type', $type)->delete();
    }
    public function updateComponent($type, $data)
    {
        $this->assignments()->where('assignable_type', $type)->update([
            'assignable_id' => $data->id,
        ]);
    }
    public function reorderComponent($type, $order)
    {
        $this->assignments()->where('assignable_type', $type)->update([
            'order' => $order,
        ]);
    }
    public function getComponentOrder($type)
    {
        return $this->assignments()
            ->where('assignable_type', $type)
            ->orderBy('order')
            ->first();
    }
    public function getComponentCount($type)
    {
        return $this->assignments()
            ->where('assignable_type', $type)
            ->count();
    }

    // public function getSkills()
    // {
    //     return $this->assignments()
    //         ->where('assignable_type', Skill::class)
    //         ->orderBy('order')
    //         ->get()
    //         ->map(function ($assignment) {
    //             return $assignment->assignable;
    //         });
    // }
    // public function getExperiences()
    // {
    //     return $this->assignments()
    //         ->where('assignable_type', Experience::class)
    //         ->orderBy('order')
    //         ->get()
    //         ->map(function ($assignment) {
    //             return $assignment->assignable;
    //         });
    // } 
    // public function getServices()
    // {
    //     return $this->assignments()
    //         ->where('assignable_type', Service::class)
    //         ->orderBy('order')
    //         ->get()
    //         ->map(function ($assignment) {
    //             return $assignment->assignable;
    //         });
    // }
    // public function getPortfolios()
    // {
    //     return $this->assignments()
    //         ->where('assignable_type', Portfolio::class)
    //         ->orderBy('order')
    //         ->get()
    //         ->map(function ($assignment) {
    //             return $assignment->assignable;
    //         });
    // }
    // public function getTestimonials()
    // {
    //     return $this->assignments()
    //         ->where('assignable_type', Testimonial::class)
    //         ->orderBy('order')
    //         ->get()
    //         ->map(function ($assignment) {
    //             return $assignment->assignable;
    //         });
    // }








    // public function skills()
    // {
    //     return $this->hasMany(Skill::class);
    // }

    // public function experiences()
    // {
    //     return $this->hasMany(Experience::class);
    // }

    // public function services()
    // {
    //     return $this->hasMany(Service::class);
    // }

    // public function portfolios()
    // {
    //     return $this->hasMany(Portfolio::class);
    // }

    // public function testimonials()
    // {
    //     return $this->hasMany(Testimonial::class);
    // }

    // public function portfolioCategories()
    // {
    //     return $this->hasMany(PortfolioCategory::class);
    // }


    public function getActiveCv()
    {
        return $this->where('is_active', true)->first();
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
