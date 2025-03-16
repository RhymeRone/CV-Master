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
        'image'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::deleting(function ($testimonial) {
            if ($testimonial->image) {
                Storage::disk('public')->delete($testimonial->image);
            }
            CVAssignment::where('assignable_type', Testimonial::class)
                ->where('assignable_id', $testimonial->id)
                ->delete();
        });
    }

    
} 