<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{

   protected $fillable = [
        'cinema_id',
        'name',
        'hall_id',
        'seat_row_count',
        'seat_column_count',
    ];



    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }

      public function seats()
    {
        return $this->hasMany(Seat::class);
    }


      public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }
}
