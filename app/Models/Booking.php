<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
protected $fillable = [
    'user_id',
    'showtime_id',
    'seats',
    'status',
];

protected $casts = [
    'seats' => 'array',
];





    public function user()
    {
        return $this->belongsTo(User::class);
    } 
     public function showtime()
    {
        return $this->belongsTo(Showtime::class);
    }

     public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

       public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
