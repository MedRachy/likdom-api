<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;

class AbonmtController extends Controller
{

    public function index()
    {
        return view('Admin.Abonmt.index');
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
                $actionBtn = '<a href="' . route("admin.reserv.show", $subscription->id) . '" target="_blank" class="edit btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                <a href="' . route("admin.reserv.edit", $subscription->id) . '" class="delete btn btn-secondary btn-sm"><i class="fas fa-edit"></i></a>';
                return $actionBtn;
            })
            ->addColumn('offer', function (Subscription $subscription) {
                return $subscription->offer->name;
            })
            ->toJson();
    }

    public function create()
    {
        return view("Admin.Abonmt.create");
    }

    public function store(Request $request)
    {

        $request->validate([
            'jour' => 'required|array',
        ]);

        $passages = collect();
        $journees =  $request->input('jour');

        foreach ($journees as $jour) {
            $passages->push(["jour" => $jour, "heure" =>  $request->input($jour)]);
        }


        $pieces = [
            'niveau' => $request->niveau,
            'chambre' => $request->chambre,
            'cuisine' => $request->cuisine,
            'toilette' => $request->toilette,
            'salon_traditionnel' => $request->salon_traditionnel,
            'salon_moderne' => $request->salon_moderne,
            'sejour' => $request->sejour,
            'coure' => $request->coure,
            'terasse' => $request->terasse,
            'buanderie' => $request->buanderie,
            'garage' => $request->garage,
        ];

        $reservation = Reservation::create([
            'user_id' => $request->input('user_id'),
            'offer_id' => $request->input('offer_id'),
            'type_passage' => 'abonnement',
            'start_date' => $request->input('start_date'),
            'passages' => $passages,
            'type_logement' => $request->input('type_logement'),
            'pieces' => $pieces,
            'city' => $request->input('city'),
            'adresse' => $request->input('adresse'),
            'Emp_selected' => $request->input('Emp_selected'),
            'confirmed' => $request->input('confirmed')
        ]);

        // TODO : update prix
        // $reservation->update([
        //     'prix' => $reservation->getPrix()
        // ]);

        return redirect()->action(
            [ReservController::class, 'show'],
            $reservation->id
        );
    }
}
