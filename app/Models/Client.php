<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Client extends Model
{
    use HasFactory, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phoneNumber',
        'password',
        'gender',
        'weight',
        'height',
        'age',
        'bmi',
        'bmi_description',
        'image'
    ];

    protected $casts = [
        'id' => 'integer',
        'weight' => 'integer',
        'height' => 'integer',
        'age' => 'integer',
        'bmi' => 'double',
        // Add other integer columns here
    ];

    protected $hidden = ['password'];

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }
}
