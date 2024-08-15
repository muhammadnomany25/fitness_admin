<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'titleAr',
        'titleEn',
        'status',
        'descriptionAr',
        'descriptionEn',
        'image',
        'videoUrl',
        'duration',
        'type',
        'level',
        'body_part_id',
        'equipment_id',
    ];

    protected $casts = [
        'body_part_id' => 'integer',
        'equipment_id' => 'integer',
    ];

    public function body_part()
    {
        return $this->belongsTo(BodyPart::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function favourites()
    {
        return $this->hasMany(WorkoutFavourite::class, 'exercise_id');
    }
}
