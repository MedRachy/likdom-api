<?php

namespace App\Http\Controllers\Admin;

use App\Events\ReservationCreated;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class AbonmtController extends Controller
{
    public function index()
    {
        return view('admin.Abonmt.index');
    }

    public function search(Request $request)
    {

        $subscriptions = Subscription::where('just_once', false)->get();

        // filter by params
        if ($request->has('params')) {

            $status = collect();
            $city = collect();
            $offer = collect();
            $query = $request->collect();
            // remove items coming with request datatable
            $query = $query->except(['params', 'draw', 'columns', 'order', 'length', 'search', 'start', '_']);
            // status
            if ($query->has('pending')) {
                $status->push('pending');
            }
            if ($query->has('valid')) {
                $status->push('valid');
            }
            if ($query->has('cancel')) {
                $status->push('cancel');
            }
            if ($query->has('concluded')) {
                $status->push('concluded');
            }
            // city
            if ($query->has('Rabat')) {
                $city->push('Rabat');
            }
            if ($query->has('Mohammedia')) {
                $city->push('Mohammedia');
            }
            if ($query->has('Casablanca')) {
                $city->push('Casablanca');
            }
            // offer 
            if ($query->has('offer_1')) {
                $offer->push(1);
            }
            if ($query->has('offer_2')) {
                $offer->push(2);
            }
            if ($query->has('offer_3')) {
                $offer->push(3);
            }
            if ($query->has('offer_4')) {
                $offer->push(4);
            }
            if ($query->has('offer_5')) {
                $offer->push(5);
            }
            if ($query->has('offer_6')) {
                $offer->push(6);
            }
            //  filter by status 
            if ($status->isNotEmpty()) {
                $subscriptions = $subscriptions->filter(function ($value) use ($status) {
                    return $status->contains($value->status);
                });
            }
            // filter by city
            if ($city->isNotEmpty()) {
                $subscriptions = $subscriptions->filter(function ($value) use ($city) {
                    return $city->contains($value->city);
                });
            }
            // filter by offer
            if ($offer->isNotEmpty()) {
                $subscriptions = $subscriptions->filter(function ($value) use ($offer) {
                    return $offer->contains($value->offer_id);
                });
            }
            // filter by min_price
            if ($query->has('min_price')) {
                $min_price = $query['min_price'];
                $subscriptions = $subscriptions->filter(function ($value) use ($min_price) {
                    return $value->price >= $min_price;
                });
            }
            // filter by max_price
            if ($query->has('max_price')) {
                $max_price = $query['max_price'];
                $subscriptions = $subscriptions->filter(function ($value) use ($max_price) {
                    return $value->price <= $max_price;
                });
            }

            // filter by start_date
            if ($query->has('start_date')) {
                $start_date = $query['start_date'];
                $subscriptions = $subscriptions->filter(function ($value) use ($start_date) {
                    return $value->start_date >=  $start_date;
                });
            }
            // filter by end_date
            if ($query->has('end_date')) {
                $end_date = $query['end_date'];
                $subscriptions = $subscriptions->filter(function ($value) use ($end_date) {
                    return $value->end_date <=  $end_date;
                });
            }
        }

        return datatables()->of($subscriptions)
            ->addColumn('action', function (Subscription $subscription) {
                $actionBtn = '<a href="' . route("admin.abonmt.show", $subscription->id) . '" target="_blank" class="edit btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                <a href="' . route("admin.abonmt.edit", $subscription->id) . '" class="delete btn btn-secondary btn-sm"><i class="fas fa-edit"></i></a>';
                return $actionBtn;
            })
            ->addColumn('offer', function (Subscription $subscription) {
                if ($subscription->offer()->exists()) {
                    return $subscription->offer->name;
                }
            })
            ->toJson();
    }

    public function create()
    {
        return view("admin.Abonmt.create");
    }

    public function store(Request $request)
    {
        // validation 
        $request->validate([
            'offer_id' => 'required',
            'start_date' => 'required|date',
            'nbr_hours' => 'required|integer',
            'nbr_employees' => 'required|integer',
            'nbr_months' => 'required|integer',
            'day' => 'required|array',
            'city' => 'required',
            'adress' => 'required'
        ]);
        // generate passages
        $passages = collect();
        $days =  $request->input('day');

        foreach ($days as $day) {
            $passages->push(["day" => $day, "time" =>  $request->input($day)]);
        }

        // generat the end_date
        $end_date = Carbon::parse($request->start_date)->addMonths($request->nbr_months);

        $subscription = Subscription::create([
            'user_id' =>  $request->user_id,
            'offer_id' => $request->offer_id,
            'start_date' => $request->start_date,
            'nbr_hours' => $request->nbr_hours,
            'nbr_employees' => $request->nbr_employees,
            'passages' => $passages,
            'nbr_months' => $request->nbr_months,
            'end_date' => $end_date,
            'city' => $request->city,
            'adress' => $request->adress,
            'confirmed' => $request->confirmed,
        ]);

        // TODO : calculate and update price
        // $subscription->update([
        //     'prix' => $subscription->getPrix()
        // ]);

        // for testing
        event(new ReservationCreated($subscription->id, 'abonmt'));

        // delete user cached subscriptions 
        Cache::forget('user_' . $subscription->user_id . 'subscriptions');

        return redirect()->action(
            [AbonmtController::class, 'show'],
            $subscription->id
        );
    }

    public function show($id)
    {
        $subscription = Subscription::find($id);
        if ($subscription) {
            return view('admin.Abonmt.show')->with('sub', $subscription);
        } else {
            return view('admin.Abonmt.404');
        }
    }

    public function edit($id)
    {
        $subscription = Subscription::find($id);

        $empolyees_dispo = Employee::where('city', $subscription->city)
            ->where('availability', 'available')->get();

        return view('admin.Abonmt.edit', [
            'sub' => $subscription,
            'employees' => $empolyees_dispo
        ]);
    }

    public function update(Request $request, $id)
    {
        $subscription = Subscription::find($id);
        // edit start date
        if ($request->has('edit_start_date')) {
            $request->validate([
                'start_date' => 'required|date',
            ]);
            // generat the end_date
            $end_date = Carbon::parse($request->start_date)->addMonths($subscription->nbr_months);
            $subscription->update([
                'start_date' => $request->start_date,
                'end_date' => $end_date
            ]);
        }
        // update passages 
        if ($request->has('edit_passages')) {

            $request->validate([
                'day' => 'required|array',
            ]);

            $passages = collect();
            $days =  $request->day;

            foreach ($days as $day) {
                $passages->push(["day" => $day, "time" =>  $request->input($day)]);
            }
            $subscription->update(['passages' => $passages]);
        }
        // update statut
        if ($request->has('edit_status') && $request->filled('status')) {

            if ($request->status == 'concluded') {
                // add to table enregistrements 
                foreach ($subscription->employees as $emply) {
                    $subscription->emplyHistory()->attach($emply->id);
                }
                // remove employee from subscription_employee
                $subscription->employees()->detach();
            } elseif ($request->status == 'cancel') {
                // remove employee from subscription_employee
                $subscription->employees()->detach();
            }

            $subscription->update(['status' => $request->status]);
        }
        // add or remove emloyees for a subscription
        if ($request->has('edit_Emp_selected')) {

            if (!empty($request->Emp_selected)) {
                // attach to employees_reservations
                $subscription->employees()->sync($request->Emp_selected);
                $subscription->update(['status' => 'valid']);
            } else {
                $subscription->employees()->detach();
            }
        }
        // delete user cached subscriptions 
        Cache::forget('user_' . $subscription->user_id . 'subscriptions');

        return redirect()->action(
            [AbonmtController::class, 'show'],
            $id
        );
    }

    public function destroy($id)
    {
        $subscription = Subscription::find($id);
        // remove employee from subscription_employee
        $subscription->employees()->detach();
        $subscription->delete();
        // delete user cached subscriptions 
        Cache::forget('user_' . $subscription->user_id . 'subscriptions');

        return redirect()->action([AbonmtController::class, 'index']);
    }
}
