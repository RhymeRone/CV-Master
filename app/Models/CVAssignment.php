<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CVAssignment extends Model
{
    protected $table = 'cv_assignments';
    protected $fillable = [
        'cv_information_id',
        'assignable_id',   // Bileşenin ID'si
        'assignable_type', // Bileşenin sınıf adı (App\Models\Skill, App\Models\Experience, vb.)
        'order',           // Sıralama için
    ];
    
    public function cv()
    {
        return $this->belongsTo(CVInformation::class, 'cv_information_id');
    }
    
    public function assignable()
    {
        return $this->morphTo();
    }
}
