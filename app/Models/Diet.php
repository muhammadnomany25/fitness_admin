<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diet extends Model
{
    use HasFactory;

    protected $fillable = ['titleAr', 'titleEn', 'category_diet_id', 'calories', 'carbs', 'protein', 'fat', 'total_time', 'status', 'ingredientsAr', 'ingredientsEn', 'descriptionAr', 'descriptionEn', 'image', 'suitable_for'];

    protected $casts = [
        'category_diet_id' => 'integer',
        'suitable_for' => 'array',
    ];

    public function category_diet()
    {
        return $this->belongsTo(CategoryDiet::class);
    }

    public function favourites()
    {
        return $this->hasMany(DietFavourite::class, 'meal_id');
    }
}
