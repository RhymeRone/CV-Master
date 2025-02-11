<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
    /** @use HasFactory<\Database\Factories\SkillFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'level',
        'color',
        'cv_information_id'
    ];

    protected $casts = [
        'level' => 'integer'
    ];

    public function cvInformation()
    {
        return $this->belongsTo(CVInformation::class);
    }
}
