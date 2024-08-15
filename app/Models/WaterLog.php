<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaterLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'nameAr',
        'nameEn',
        'type',
        'amount',
        'client_id'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
