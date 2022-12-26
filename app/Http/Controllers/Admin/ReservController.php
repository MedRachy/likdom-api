<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Employee;
use App\Models\Subscription;
use Carbon\Carbon;
use DataTables;

class ReservController extends Controller
{

    public function index()
    {

        return view('Admin.Reserv.index');
    }

    public function search(Request $request)
    {

        $reservations = Subscription::where('just_once', true)->get();

        // filter by params
        if ($request->has('params')) {

            $status = collect();
            $city = collect();
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

            //  filter by status 
            if ($status->isNotEmpty()) {
                $reservations = $reservations->filter(function ($value) use ($status) {
                    return $status->contains($value->status);
                });
            }
            // filter by city
            if ($city->isNotEmpty()) {
                $reservations = $reservations->filter(function ($value) use ($city) {
                    return $city->contains($value->city);
                });
            }
            // filter by min_price
            if ($query->has('min_price')) {
                $min_price = $query['min_price'];
                $reservations = $reservations->filter(function ($value) use ($min_price) {
                    return $value->price >= $min_price;
                });
            }
            // filter by max_price
            if ($query->has('max_price')) {
                $max_price = $query['max_price'];
                $reservations = $reservations->filter(function ($value) use ($max_price) {
                    return $value->price <= $max_price;
                });
            }

            // filter by date_passage
            if ($query->has('date_passage')) {
                $date_passage = $query['date_passage'];
                $reservations = $reservations->filter(function ($value) use ($date_passage) {
                    return $value->start_date == $date_passage;
                });
            }
            // filter by start_time
            if ($query->has('start_time')) {
                $start_time = $query['start_time'];
                $reservations = $reservations->filter(function ($value) use ($start_time) {
                    return $value->start_time == $start_time;
                });
            }

            // filter by start_date
            if ($query->has('start_date')) {
                $start_date = $query['start_date'];
                $reservations = $reservations->filter(function ($value) use ($start_date) {
                    return $value->start_date >=  $start_date;
                });
            }
            // filter by end_date
            if ($query->has('end_date')) {
                $end_date = $query['end_date'];
                $reservations = $reservations->filter(function ($value) use ($end_date) {
                    return $value->start_date <=  $end_date;
                });
            }
        }

        return datatables()->of($reservations)
            ->addColumn('action', function (Subscription $reservation) {
                $actionBtn = '<a href="' . route("admin.reserv.show", $reservation->id) . '" target="_blank" class="edit btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                <a href="' . route("admin.reserv.edit", $reservation->id) . '" class="delete btn btn-secondary btn-sm"><i class="fas fa-edit"></i></a>';
                return $actionBtn;
            })
            ->toJson();
    }

    public function create()
    {
        return view("Admin.Reserv.create");
    }


    public function store(Request $request)
    {

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

            'service' => $request->input('service'),
            'type_logement' => $request->input('type_logement'),
            'date_passage' => $request->input('date_passage'),
            'start_time' => $request->input('start_time'),
            'pieces' => $pieces,
            'type_surface' => $request->input('type_surface'),
            'equipements' => $request->input('equipements'),
            'produits' => $request->input('produits'),
            'user_id' => $request->input('user_id'),
            'ville' => $request->input('ville'),
            'adresse' => $request->input('adresse'),
            'confirmed' => $request->input('confirmed')
        ]);
        // update prix 
        $reservation->update([
            'prix' => $reservation->getPrix()
        ]);
        return redirect()->action(
            [ReservController::class, 'show'],
            $reservation->id
        );
    }


    public function show($id)
    {

        $reserv = Reservation::find($id);
        if ($reserv) {
            // dd($reserv);
            // dd($reserv->emplyHistory()->exists());
            return view('Admin.Reserv.show')->with('reserv', $reserv);
        } else {
            return view('Admin.Reserv.404');
        }
    }

    public function code(Request $request)
    {
        $code = $request->input('code');
        $reserv = Reservation::where('code', $code)->first();
        if ($reserv) {
            return redirect()->action([ReservController::class, 'show'], $reserv->id);
        } else {
            return view('Admin.Reserv.404');
        }
    }

    public function edit($id)
    {
        $reserv = Reservation::find($id);
        $empolyees_dispo = Employee::where('ville', $reserv->ville)
            ->where('disponibilite', 'disponible')->get();

        // if ($reserv->pack()->exists()) {

        //     $date_debut = $reserv->date_debut;

        //     foreach ($reserv->passages as $passage) {

        //         $start_time = $passage['jour'];
        //         $reserv_dayName = $passage['heure'];
        //         $empolyees_dispo = $empolyees_dispo->reject(function ($value, $key) use ($date_debut, $reserv_dayName, $start_time) {

        //             foreach ($value->reservations as $reserv) {
        //                 // vérifie si dispo  par rapport avec les reservations unique  attribué  
        //                 $dayName = Carbon::parse($reserv->date_passage)->locale('fr')->dayName;
        //                 if ($date_debut <= $reserv->date_passage ) {
        //                     if ($dayName == $reserv_dayName && $reserv->start_time == $start_time) {
        //                         return true;
        //                     }
        //                 }
        //                 //  vérifie si dispo par rapport avec les abonnements attribué
        //                 if ($reserv->pack) {
        //                     if ($reserv->date_debut >= $date_debut) {

        //                         foreach ($reserv->abonnement->passages as $passage) {
        //                             if ($passage["day"] == $reserv_dayName && $passage["time"] == $start_time) {
        //                                 return true;
        //                             }
        //                         }
        //                     }
        //                 }
        //             }
        //         });
        //     }
        // } else {

        //     $date_passage = $reserv->date_passage;
        //     $start_time = $reserv->start_time;
        //     $dayName = Carbon::parse($date_passage)->locale('fr')->dayName;

        //     // list des Empolyee disponible pour cette réservation     
        //     $empolyees_dispo = $empolyees_dispo->reject(function ($value, $key) use ($date_passage, $start_time, $dayName) {

        //         // if($value->reservations()->exists()) { }
        //         foreach ($value->reservations as $reserv) {
        //             // vérifie si dispo par rapport avec les reservations unique  attribué   
        //             if ($reserv->date_passage == $date_passage && $reserv->start_time == $start_time) {
        //                 return true;
        //             }
        //             // vérifie si dispo  par rapport avec les abonnements attribué
        //             if ($reserv->abonnement) {
        //                 if ($reserv->abonnement->date_debut <= $date_passage && $reserv->abonnement->date_fin >= $date_passage) {

        //                     foreach ($reserv->abonnement->passages as $passage) {
        //                         if ($passage["day"] == $dayName && $passage["time"] == $start_time) {
        //                             return true;
        //                         }
        //                     }
        //                 }
        //             }
        //         }
        //     });
        // }

        return view('Admin.Reserv.edit', [
            'reserv' => $reserv,
            'employees' => $empolyees_dispo
        ]);
    }


    public function update(Request $request, $id)
    {

        $reserv = Reservation::find($id);
        // edit date & heure passage
        if ($request->has('edit_passage')) {

            $request->validate([
                'date_passage' => 'required_without:date_debut|date',
                'date_debut' => 'required_without:date_passage|date',
                'start_time' => 'required_without:date_debut',
            ]);
            $reserv->update([
                'date_passage' => $request->input('date_passage'),
                'start_time' => $request->input('start_time'),
                'date_debut'  => $request->input('date_debut'),
            ]);
        }

        // update pack passages 
        if ($request->has('edit_pack_passages')) {

            $request->validate([
                'jour' => 'required|array',
            ]);

            $passages = collect();
            $journees =  $request->input('jour');

            foreach ($journees as $jour) {
                $passages->push(["jour" => $jour, "heure" =>  $request->input($jour)]);
            }
            $reserv->update([
                'passages' => $passages
            ]);
        }

        // update statut
        if ($request->has('edit_statut') && $request->filled('statut')) {

            if ($request->input('statut') == 'terminer') {
                // add to table enregistrements 
                foreach ($reserv->employees as $emply) {
                    $reserv->emplyHistory()->attach($emply->id);
                }
                // remove employee from reservation_employee
                $reserv->employees()->detach();
            }

            if ($request->input('statut') == 'annuler') {
                $reserv->employees()->detach();
            }
            $reserv->update(['statut' => $request->input('statut')]);
        }

        // add or remove emloyees for a reservation
        // if a value is present on the request and is not empty
        if ($request->has('edit_Emp_selected')) {

            if (!empty($request->input('Emp_selected'))) {
                // attach to employees_reservations
                $reserv->employees()->sync($request->input('Emp_selected'));
                $reserv->update(['statut' => 'valider']);
            } else {
                $reserv->employees()->detach();
            }
        }
        return redirect()->action(
            [ReservController::class, 'show'],
            $id
        );
    }

    public function destroy($id)
    {

        $reserv = Reservation::find($id);
        // remove employee from reservation_employee
        $reserv->employees()->detach();
        $reserv->delete();
        return redirect()->action([ReservController::class, 'index']);
    }
}
