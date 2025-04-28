<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{

   protected $fillable = [
        
        'hall_id',
        'seat_row',
        'seat_column',
        'seat_type',
        'seat_price'
    ];




    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }

       public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
