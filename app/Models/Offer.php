<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'label',
        'name',
        'description',
        'nbr_passages',
        'start_price'
    ];

    // an offer have many subscriptions
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
