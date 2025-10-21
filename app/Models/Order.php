<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'date',
        'total_amount',
        'status',
        'pickup_time',
        'remarks',
        'customer_name',
        'order_id'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    protected static function booted()
    {
        static::creating(function ($order) {
            if (!$order->order_id) {
                $order->order_id = self::generateOrderId();
            }
        });
    }

    public static function generateOrderId()
    {
        $today = Carbon::now()->format('dmy');

        $lastOrder = self::whereDate('created_at', Carbon::today())
            ->orderBy('id', 'desc')
            ->first();

        if ($lastOrder) {
            $lastIncrement = (int) explode('-', $lastOrder->order_id)[1];
            $newIncrement = $lastIncrement + 1;
        } else {
            $newIncrement = 1;
        }

        return $today . '-' . str_pad($newIncrement, 4, '0', STR_PAD_LEFT);
    }
}
