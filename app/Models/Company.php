<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{


 protected $fillable = [
        'company_name',
        'company_email',
        'company_phone',
        
    ];



 public function cinemas()
{
    return $this->hasMany(Cinema::class, 'owner_company_id');
}


 
}
