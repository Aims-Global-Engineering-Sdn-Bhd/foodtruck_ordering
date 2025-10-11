<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable=[
      'name',
      'price',
      'description',
      'avail_status',
        'category',
        'remark',
        'url_food',
    ];

    public function bookings(){
        return $this->hasMany(Booking::class, 'menu_id', 'id');
    }
}
