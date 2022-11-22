<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionResource;
use App\Models\Employee;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SubscriptionsController extends Controller
{

    public function store_once(Request $request)
    {
        // autorization 

        // validation 
        $request->validate([
            'start_date' => 'required|date|after:now',
            'start_time' => 'required|string',
            'nbr_hours' => 'required|integer',
            'nbr_employees' => 'required|integer',
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

    public function recap($id)
    {
        $subscription = Subscription::find($id);
        if ($subscription) {
            if (!Gate::allows('access-sub', $subscription)) {
                // return response('forbidden', 403);
                return  response()->json(['message' => 'Not authorized.'], 403);
            }
            // only access for confirmation or repeter 
            if ($subscription->confirmed && $subscription->statut != "concluded") {
                return  response()->json(['message' => 'Not authorized.'], 403);
            }
            return new SubscriptionResource($subscription);
        } else {
            return  response()->json(['message' => 'Not found.'], 404);
        }
    }

    public function to_confirm($id)
    {
        $subscription = Subscription::find($id);
        if ($subscription) {
            if (!Gate::allows('access-sub', $subscription)) {
                // return response('forbidden', 403);
                return  response()->json(['message' => 'Not authorized.'], 403);
            }
            $subscription->update([
                'confirmed' => true,
            ]);
            return  response()->json(['message' => 'confirmed'], 200);
        } else {
            return  response()->json(['message' => 'Not found.'], 404);
        }
    }

    public function get_total_price($nbr_hours = 2, $nbr_employees = 1)
    {
        $total_price = 0;
        $hour_price = 75;

        if ($nbr_hours >= 2 && $nbr_employees >= 1) {
            $total_price = $nbr_hours * $hour_price;
            $total_price = $total_price * $nbr_employees;
            return  response()->json(['total_price' => $total_price], 200);
        } else {
            return  response()->json(['message' => 'unvalid inputs'], 403);
        }
    }
    // public function get_date_availability($date)
    // {

    //     $subscriptions = Subscription::where('just_once', 1)
    //         ->where('start_date', $date)->get();

    //     if ($subscriptions->count() === 0) {
    //         return response()->json([
    //             'message' => 'date selected is available'
    //         ]);
    //     }
    // }
}
