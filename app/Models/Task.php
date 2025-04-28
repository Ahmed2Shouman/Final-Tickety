<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_name',
        'description',
        'is_completed',
        'company_id',
    ];

    // A task belongs to a company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // You can add this if tasks are assigned
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
