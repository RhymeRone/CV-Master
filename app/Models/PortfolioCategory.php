<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PortfolioCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'cv_information_id'
    ];

    // Otomatik slug oluşturma
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($category) {
            $category->slug = $category->generateUniqueSlug($category->name);
        });

        static::updating(function ($category) {
            if ($category->isDirty('name')) {
                $category->slug = $category->generateUniqueSlug($category->name);
            }
        });
    }

    // Benzersiz slug oluşturma metodu
    protected function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        
        return $count ? "{$slug}-{$count}" : $slug;
    }

    // Route model binding için slug kullanma
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function cvInformation()
    {
        return $this->belongsTo(CVInformation::class);
    }

    public function portfolios()
    {
        return $this->belongsToMany(Portfolio::class, 'portfolio_portfolio_category');
    }
} 