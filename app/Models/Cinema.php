<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cinema extends Model
{
 protected $fillable = [
        'name',
        'location',
        'company_id',
        'admin_id',
    
    ];





    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    } 
    
       public function halls()
    {
        return $this->hasMany(Hall::class);
    }

      public function showtimes()
    {
        return $this->hasManyThrough(
            Showtime::class,  // Final model
            Hall::class,      // Intermediate model
            'cinema_id',      // FK on halls table...
            'hall_id',        // FK on showtimes table...
            'id',             // Local key on cinemas table...
            'id'              // Local key on halls table...
        );
    }

}
