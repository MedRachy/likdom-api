<?php

namespace App\Http\Controllers\api;

use App\Events\ReservationCreated;
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

    public function get_all_sub()
    {
        // get all pending or valid subscriptions :
        $subscriptions = Subscription::where('user_id', Auth::id())
            ->where('status', '!=', 'concluded')
            ->with('offer')
            ->latest()
            ->get();

        return new SubscriptionResource($subscriptions);
    }

    public function get_all_concluded_sub()
    {
        // get all pending or valid subscriptions :
        $subscriptions = Subscription::where('user_id', Auth::id())
            ->where('status', 'concluded')
            ->with('offer')
            ->latest()
            ->get();

        return new SubscriptionResource($subscriptions);
    }

    public function store_sub(Request $request)
    {

        // validation 
        $request->validate([
            'offer_id' => 'required',
            'start_date' => 'required|date|after:tomorrow',
            'nbr_hours' => 'required|integer',
            'nbr_employees' => 'required|integer',
            'nbr_months' => 'required|integer',
            'passages' => 'required',
            'location' => 'required',
            'city' => 'required',
            'price' => 'required'
        ]);

        // generat the end_date
        $end_date = Carbon::parse($request->start_date)->addMonths($request->nbr_months);

        $subscription = Subscription::create([
            'user_id' => Auth::id(),
            'offer_id' => $request->offer_id,
            'start_date' => $request->start_date,
            'nbr_hours' => $request->nbr_hours,
            'nbr_employees' => $request->nbr_employees,
            'passages' => json_decode($request->passages),
            'location' => json_decode($request->location),
            'nbr_months' => $request->nbr_months,
            'end_date' => $end_date,
            'city' => $request->city,
            'price' => $request->price,
        ]);

        // run event 
        event(new ReservationCreated($subscription->id, 'abonmt'));

        return new SubscriptionResource($subscription);
    }

    public function store_reserv(Request $request)
    {
        // autorization 

        // validation 
        $request->validate([
            'start_date' => 'required|date|after:now',
            'start_time' => 'required|string',
            'nbr_hours' => 'required|integer',
            'nbr_employees' => 'required|integer',
            'location' => 'required',
            'city' => 'required',
            'price' => 'required'
        ]);

        $reservation = Subscription::create([
            'user_id' => Auth::id(),
            'start_date' => $request->start_date,
            'start_time' => $request->start_time,
            'nbr_hours' => $request->nbr_hours,
            'nbr_employees' => $request->nbr_employees,
            'location' => json_decode($request->location),
            'city' => $request->city,
            'just_once' => true,
            'price' => $request->price,
        ]);

        // run event 
        event(new ReservationCreated($reservation->id, 'reserv'));

        return new SubscriptionResource($reservation);
    }

    public function recap($id)
    {
        $subscription = Subscription::where('id', $id)
            ->with('offer')
            ->first();
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

    public function get_pro_total_price($nbr_hours = 1, $nbr_employees = 1, $nbr_passages = 1)
    {
        $total_price = 0;
        $hour_price = 75;

        if ($nbr_hours >= 2 && $nbr_employees >= 1 && $nbr_passages  >= 1) {
            $total_hours = $nbr_passages * 4;
            $total_price = $nbr_hours * $hour_price * $total_hours;
            $total_price = $total_price * $nbr_employees;
            return  response()->json(['total_price' => $total_price], 200);
        } else {
            return  response()->json(['message' => 'unvalid inputs'], 403);
        }
    }

    public function get_part_total_price($nbr_hours = 2, $nbr_employees = 1, $nbr_passages = 1)
    {
        $total_price = 0;
        $hour_price = 55;

        if ($nbr_hours >= 2 && $nbr_employees >= 1 && $nbr_passages  >= 1) {
            $total_hours = $nbr_passages * 4;
            $total_price = $nbr_hours * $hour_price * $total_hours;
            $total_price = $total_price * $nbr_employees;
            return  response()->json(['total_price' => $total_price], 200);
        } else {
            return  response()->json(['message' => 'unvalid inputs'], 403);
        }
    }
}
