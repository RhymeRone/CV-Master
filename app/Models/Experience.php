<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Experience extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'position',
        'company',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($experience) {
            // Deneyim silindiğinde, tüm atamalarını temizle
            CVAssignment::where('assignable_type', Experience::class)
                ->where('assignable_id', $experience->id)
                ->delete();
        });
    }


    // Tarih formatını otomatik dönüştürür
    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = $value ? date('Y-m-d', strtotime($value)) : null;
    }

    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] = $value ? date('Y-m-d', strtotime($value)) : null;
    }

    public function getStartDateAttribute($value)
    {
        // Veritabanından alınan değeri, form için uygun formata dönüştür
        return $value ? date('Y-m-d', strtotime($value)) : null;
    }

    public function getEndDateAttribute($value)
    {
        return $value ? date('Y-m-d', strtotime($value)) : null;
    }
    // public function cvInformation()
    // {
    //     return $this->belongsTo(CVInformation::class);
    // }
}