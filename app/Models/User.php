<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Laravel\Cashier\Billable;  // Add this import
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
      use Notifiable, Billable;  // Add Billable to the user model

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role_id',
        'salary',
        'company_id' , 
        'cinema_id',
        'profile_image'
        
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }


   public function superadminPayments()
    {
        return $this->hasMany(SuperadminPayment::class);
    }

    public function seats()
    {
        return $this->hasManyThrough(Seat::class, Booking::class);
    }

    public function showtimes()
    {
        return $this->hasManyThrough(Showtime::class, Booking::class);
    }


 // Relationship: A user belongs to a company
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    // Relationship: A user belongs to a cinema (only for admins and staff)
    public function cinema()
    {
        return $this->belongsTo(Cinema::class, 'cinema_id');
    }
    public function role()
{
    return $this->belongsTo(Role::class);
}

   
}
