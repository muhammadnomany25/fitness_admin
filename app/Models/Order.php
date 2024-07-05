<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;

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
    ];

    protected $casts = [
        'status' => OrderStatus::class,
    ];
    public function invoiceItems()
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

}
