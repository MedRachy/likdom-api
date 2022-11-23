<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'offer_id',
        'service',
        'just_once',
        'start_date',
        'start_time',
        'end_date',
        'passages',
        'nbr_hours',
        'nbr_employees',
        'location',
        'city',
        'products',
        'confirmed',
        'status',
        'nbr_months',
        'price',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'just_once' => 'boolean',
        'products' => 'boolean',
        'confirmed' => 'boolean',
        'location' => 'array',
        'passages' => 'array',
    ];

    // a subscription belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // a subscription belongs to one offer
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
    // a subscription can have one or many employees attached to it 
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_subscription');
    }
    // history of employees attached to one subscription 
    public function emplyHistory()
    {
        return $this->belongsToMany(Employee::class, 'records');
    }
}
