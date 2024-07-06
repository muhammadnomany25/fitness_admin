<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManualPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'reason',
        'due_date',
        'cost',
        'order_status',
        'notes',
    ];
}
