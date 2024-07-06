<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Technician extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'name',
        'phoneNumber',
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    protected $hidden = [
        'password', 'remember_token',
    ];
}
