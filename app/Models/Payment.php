<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

   protected $fillable = [
          'booking_id',  
        'user_id',
        'amount',
        'currency',
        'status',
        'method',
        'card_brand',
        'card_last4',
        'transaction_id',
        'stripe_receipt_url',
        'paid_at'
    ];




   public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
