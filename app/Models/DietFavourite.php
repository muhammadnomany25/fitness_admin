<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DietFavourite extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'meal_id'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function meal()
    {
        return $this->belongsTo(Diet::class, 'meal_id');
    }
}
