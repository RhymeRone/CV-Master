<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Testimonial extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'comment',
        'job',
        'image',
        'cv_information_id'
    ];

    public function cvInformation()
    {
        return $this->belongsTo(CVInformation::class);
    }

    protected static function boot()
    {
        parent::boot();
        
        static::deleting(function ($testimonial) {
            if ($testimonial->image) {
                Storage::disk('public')->delete($testimonial->image);
            }
        });
    }
} 