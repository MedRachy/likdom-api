<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'last_name',
        'first_name',
        'phone',
        'adress',
        'city',
        'date_birth',
        'availability',
        'sex',
        'speciality',
        'image_path'
    ];

    public function getFullNameAttribute()
    {
        return "{$this->last_name} {$this->first_name}";
    }

    // an employee can be attache to one or many subscriptions 
    public function subscriptions()
    {
        return $this->belongsToMany(Subscription::class, 'employee_subscription');
    }
    // history of subscriptions attached to one employee
    public function subscriptionHistory()
    {
        return $this->belongsToMany(Subscription::class, 'records');
    }
}
