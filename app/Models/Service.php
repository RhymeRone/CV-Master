<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'icon',
        'cv_information_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($service) {
            CVAssignment::where('assignable_type', Service::class)
                ->where('assignable_id', $service->id)
                ->delete();
        });
    }
} 