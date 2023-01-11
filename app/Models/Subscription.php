<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        'adress',
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

    public function getPassagesPerMonths()
    {
        $nbr_passages = 0;
        // Periode from : start_date until end_date  
        $period = Carbon::parse($this->start_date)->daysUntil($this->end_date);
        $dates = $period->toArray();
        foreach ($this->passages as $passage) {

            for ($i = 0; $i < $period->count(); $i++) {
                // get the dayname of every date in the periode 
                $dayName = Carbon::parse($dates[$i])->locale('fr')->dayName;
                $dayName = Str::ucfirst($dayName);
                if ($passage['day'] == $dayName) {
                    $nbr_passages += 1;
                }
            }
        }
        return $nbr_passages;
    }
}
