<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'date',
        'total_amount',
        'status',
        'pickup_time',
        'remarks'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
