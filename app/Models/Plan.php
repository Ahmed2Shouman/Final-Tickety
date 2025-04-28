<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    // The attributes that are mass assignable.
    protected $fillable = [
        'name',
        'description',
        'price',
        'cinema_count',
        'stripe_plan_id',
        'stripe_price_id',

    ];

    /**
     * Get all subscriptions associated with the plan.
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
