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
        'icon'
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

        static::deleting(function ($category) {
            CVAssignment::where('assignable_type', PortfolioCategory::class)
                ->where('assignable_id', $category->id)
                ->delete();
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
// app/Models/PortfolioCategory.php
    public function resolveRouteBinding($value, $field = null)
    {
        // API rotalarında ID kullan
        if (request()->is('api/*')) {
            return $this->where('id', $value)->firstOrFail();
        }

        // Web rotalarında slug kullan
        return $this->where('slug', $value)->firstOrFail();
    }

    // PortfolioCategory.php'de
    public function portfolios()
    {
        return $this->belongsToMany(Portfolio::class, 'portfolio_category_portfolio');
        // Laravel otomatik olarak portfolio_category_portfolio tablosunu kullanacaktır
    }
}