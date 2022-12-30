<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'subscription_id',
        'manager_name',
        'company_name',
        'adress',
        'city',
        'rc_number',
        'capital'
    ];

    // a contract belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // a contract belongs to one subscription
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
