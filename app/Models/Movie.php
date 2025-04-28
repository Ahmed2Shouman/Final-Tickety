<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{

    protected $fillable = [
        'title',
        'description',
        'duration_minutes',
        'genre',
        'rating',
        'poster_url',
        'company_id',
        'trailer_url',
    ];


    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }
}
