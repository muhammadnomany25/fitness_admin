<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Order extends Model
{
    protected $fillable = [
        'client_name',
        'client_phone',
        'client_address',
        'client_flat_number',
        'status',
        'technician_id',
        'user_id',
        'notes',
        'visit_date',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
    ];
    public function orderInvoices()
    {
        return $this->hasMany(OrderInvoice::class);
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    public function notes()
    {
        return $this->hasMany(OrderNote::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $dates = ['visit_date', 'created_at']; // Ensure visit_date is treated as a date

    public function getCreatedAtFormattedAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

}
