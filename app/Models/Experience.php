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
        'start_year',
        'end_year',
        'cv_information_id'
    ];

    protected $casts = [
        'start_year' => 'integer',
        'end_year' => 'integer'
    ];

    public function cvInformation()
    {
        return $this->belongsTo(CVInformation::class);
    }
} 