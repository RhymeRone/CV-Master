<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Portfolio extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'link'
    ];

    public function categories()
    {
        return $this->belongsToMany(PortfolioCategory::class, 'portfolio_category_portfolio');
        // Laravel otomatik olarak portfolio_category_portfolio tablosunu kullanacaktır
    }
    // Tüm görselleri getirir
    public function images()
    {
        return $this->hasMany(PortfolioImage::class)->orderBy('sort_order');
    }

    // Sadece ana görseli getirir
    public function mainImage()
    {
        return $this->hasOne(PortfolioImage::class)->where('is_main', true);
    }

    // Ana görsel yolunu kolay erişim için accessor
    public function getMainImagePathAttribute()
    {
        return $this->mainImage ? $this->mainImage->image_path : null;
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($portfolio) {
            // İlişkili görsellerin fiziksel dosyalarını sil
            foreach ($portfolio->images as $image) {
                if ($image->image_path) {
                    Storage::disk('public')->delete($image->image_path);
                }
            }
            CVAssignment::where('assignable_type', Portfolio::class)
                ->where('assignable_id', $portfolio->id)
                ->delete();
        });
    }
}