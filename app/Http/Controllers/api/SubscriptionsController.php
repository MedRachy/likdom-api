<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionResource;
use App\Models\Employee;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionsController extends Controller
{

    public function store_once(Request $request)
    {
        // autorization 

        // validation 
        $request->validate([
            'start_date' => 'required|date|after:now',
            'start_time' => 'required',
            'nbr_hours' => 'required',
            'nbr_employees' => 'required',
            'location' => 'required',
        ]);

        $subscription = Subscription::create([
            'user_id' => Auth::id(),
            'start_date' => $request->start_date,
            'start_time' => $request->start_time,
            'nbr_hours' => $request->nbr_hours,
            'nbr_employees' => $request->nbr_employees,
            'location' => json_decode($request->location),
            'just_once' => true,
        ]);

        return new SubscriptionResource($subscription);
    }

    public function get_available_hours($date)
    {
        $hours = collect([
            '08:00',
            '09:00',
            '10:00',
            '11:00',
            '14:00',
            '15:00',
            '16:00',
            '17:00',
        ]);

        $employees = Employee::where('availability', 'available')->get();
        // TODO : filter by city

        foreach ($employees as $employee) {
            // if at least one employee dont have a subscription 
            if (!$employee->subscriptions()->exists()) {
                return $hours;
            }

            foreach ($employee->subscriptions as $subscription) {
                // if no subscription planned for that date 
                if ($subscription->start_debut != $date) {
                    return $hours;
                } else {
                    $start_time = $subscription->start_time;
                    $end_time = $start_time + $subscription->nbr_hours;
                    // reject subscription hours from Hours list
                    $hours = $hours->reject(function ($value) use ($start_time, $end_time) {
                        if ($value >= $start_time || $value <= $end_time) {
                            return true;
                        }
                    });
                }
            }
        }
        return $hours;
    }
}
