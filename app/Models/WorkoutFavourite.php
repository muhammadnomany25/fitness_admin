<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutFavourite extends Model
{
    use HasFactory;
    protected $fillable = ['client_id', 'exercise_id'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class, 'exercise_id');
    }
}
