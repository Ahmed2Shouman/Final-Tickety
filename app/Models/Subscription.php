<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',        // Company the subscription is tied to
        'plan_type',         // Plan type (e.g., Basic, Premium)
        'subscription_start',// Start date
        'subscription_end',  // End date
        'payment_status',    // Payment status (paid/pending)
        'cinema_count',      // Number of cinemas
        'active',            // Whether the subscription is active
        'plan_id',            // Whether the subscription is active
        'stripe_subscription_id',            // Whether the subscription is active
        'status',            // Whether the subscription is active
        'stripe_price_id',            // Whether the subscription is active
    ];

        // Ensure the subscription_end field is treated as a Carbon instance
    protected $dates = ['subscription_start', 'subscription_end'];

    /**
     * Get the company associated with the subscription.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function plan()
{
    return $this->belongsTo(Plan::class);
}

}
