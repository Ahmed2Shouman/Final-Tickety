<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'task_id',
  
        'is_completed',
    ];


    // Relationship to Staff (User model)
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
       // Relationship to Task model
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}
