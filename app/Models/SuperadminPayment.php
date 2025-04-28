<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperadminPayment extends Model
{
    use HasFactory;

    // Define the table name if it differs from the default naming convention
    protected $table = 'superadmin_payments';

    // Define the fillable attributes to prevent mass assignment issues
    protected $fillable = [
        'superadmin_id',    // Reference to the SuperAdmin user
        'amount',           // Payment amount
        'plan_id',           // Payment amount
        'currency',         // Currency of the payment
        'status',           // Payment status
        'method',           // Payment method (e.g., 'stripe', 'paypal')
        'transaction_id',   // Stripe or other payment provider transaction ID
        'stripe_receipt_url', // Stripe receipt URL
        'paid_at',          // Payment processed date
    ];

    // You can also define any relationships, if needed.
    // For example, if you want to associate payments with users:
    public function superadmin()
    {
        return $this->belongsTo(User::class, 'superadmin_id');
    }

    // In SuperadminPayment model
public function plan()
{
    return $this->belongsTo(Plan::class);  // Define the relationship to Plan
}

}
