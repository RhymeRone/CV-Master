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
        'link',
        'image',
        'cv_information_id'
    ];

    public function cvInformation()
    {
        return $this->belongsTo(CVInformation::class);
    }

    public function categories()
    {
        return $this->belongsToMany(PortfolioCategory::class, 'portfolio_portfolio_category');
    }

    protected static function boot()
    {
        parent::boot();
        
        static::deleting(function ($portfolio) {
            if ($portfolio->image) {
                Storage::disk('public')->delete($portfolio->image);
            }
        });
    }
} 