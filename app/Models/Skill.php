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
        'color'
    ];

    protected $casts = [
        'level' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($skill) {
            CVAssignment::where('assignable_type', Skill::class)
                ->where('assignable_id', $skill->id)
                ->delete();
        });
    }
}
