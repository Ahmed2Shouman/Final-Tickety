<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showtime extends Model
{

  protected $fillable = [
        'movie_id',
        'hall_id',
        'start_time',
        'end_time',
        'language',
        'is_3d',
        'cinema_id',
        'ticket_price',
        
    ];




    public function movie()
        {
            return $this->belongsTo(Movie::class);
        }

    public function hall()
        {
            return $this->belongsTo(Hall::class);
        }

    public function bookings()
        {
            return $this->hasMany(Booking::class);
        }


    public function cinema()
        {
            return $this->belongsTo(Cinema::class);
        }

            // Method to get seats through the hall
    // public function seats()
    // {
    //     return $this->hall->seats(); // Get all seats for the hall associated with this showtime
    // }

}
