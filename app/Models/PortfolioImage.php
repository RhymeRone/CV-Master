<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioImage extends Model
{
    protected $fillable = [
        'portfolio_id',
        'image_path',
        'is_main',
        'sort_order',
    ];
    
    protected $casts = [
        'is_main' => 'boolean',
        'sort_order' => 'integer',
    ];
    
    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}