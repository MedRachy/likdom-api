<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Employee;
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

        $reservations = Reservation::where('type_passage', 'unique')->get();
        // get only the columns needed : NOTE maybe its need all colums so the filter works !
        // $reserv = $reservations->only(['id','statut','service','ville','type_maison'
        //                                     ,'prix','date_passage','heure_passage' ]);
        // filter by params
        if ($request->has('params')) {

            $statut = collect();
            $ville = collect();
            $service = collect();
            $type_logement = collect();

            $query = $request->collect();
            // remove items coming with request datatable
            $query = $query->except(['params', 'draw', 'columns', 'order', 'length', 'search', 'start', '_']);
            // statut
            if ($query->has('en_attente')) {
                $statut->push('en_attente');
            }
            if ($query->has('valider')) {
                $statut->push('valider');
            }
            if ($query->has('annuler')) {
                $statut->push('annuler');
            }
            if ($query->has('terminer')) {
                $statut->push('terminer');
            }
            // ville
            if ($query->has('Rabat')) {
                $ville->push('Rabat');
            }
            if ($query->has('Casablanca')) {
                $ville->push('Casablanca');
            }
            if ($query->has('Mohammedia')) {
                $ville->push('Mohammedia');
            }
            // service 
            if ($query->has('menage_simple')) {
                $service->push('menage_simple');
            }
            if ($query->has('grand_menage')) {
                $service->push('grand_menage');
            }
            if ($query->has('menage_perso')) {
                $service->push('menage_perso');
            }
            if ($query->has('cristalisation')) {
                $service->push('cristalisation');
            }
            if ($query->has('desinfection')) {
                $service->push('desinfection');
            }
            if ($query->has('nettoyage_sec')) {
                $service->push('nettoyage_sec');
            }
            // type_maison
            if ($query->has('appartement')) {
                $type_logement->push('appartement');
            }
            if ($query->has('maison')) {
                $type_logement->push('maison');
            }
            if ($query->has('villa')) {
                $type_logement->push('villa');
            }
            //  filter by statut 
            if ($statut->isNotEmpty()) {
                $reservations = $reservations->filter(function ($value) use ($statut) {
                    return $statut->contains($value->statut);
                });
            }
            // filter by ville
            if ($ville->isNotEmpty()) {
                $reservations = $reservations->filter(function ($value) use ($ville) {
                    return $ville->contains($value->ville);
                });
            }
            // filter by service
            if ($service->isNotEmpty()) {
                $reservations = $reservations->filter(function ($value) use ($service) {
                    return $service->contains($value->service);
                });
            }
            // filter by type_logement
            if ($type_logement->isNotEmpty()) {
                $reservations = $reservations->filter(function ($value) use ($type_logement) {
                    return $type_logement->contains($value->type_logement);
                });
            }
            // filter by prix_min
            if ($query->has('prix_min')) {
                $prix_min = $query['prix_min'];
                $reservations = $reservations->filter(function ($value) use ($prix_min) {
                    return $value->prix >= $prix_min;
                });
            }
            // filter by prix_max
            if ($query->has('prix_max')) {
                $prix_max = $query['prix_max'];
                $reservations = $reservations->filter(function ($value) use ($prix_max) {
                    return $value->prix <= $prix_max;
                });
            }
            // filter by date_passage
            if ($query->has('date_passage')) {
                $date_passage = $query['date_passage'];
                $reservations = $reservations->filter(function ($value) use ($date_passage) {
                    return $value->date_passage == $date_passage;
                });
            }
            // filter by heure_passage
            if ($query->has('heure_passage')) {
                $heure_passage = $query['heure_passage'];
                $reservations = $reservations->filter(function ($value) use ($heure_passage) {
                    return $value->heure_passage == $heure_passage;
                });
            }
            // filter by date_debut
            if ($query->has('date_debut')) {
                $date_debut = $query['date_debut'];
                $reservations = $reservations->filter(function ($value) use ($date_debut) {
                    return $value->date_passage >=  $date_debut;
                });
            }
            // filter by date_fin
            if ($query->has('date_fin')) {
                $date_fin = $query['date_fin'];
                $reservations = $reservations->filter(function ($value) use ($date_fin) {
                    return $value->date_passage <=  $date_fin;
                });
            }
        }

        return datatables()->of($reservations)
            ->addColumn('action', function (Reservation $reservation) {
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
            'heure_passage' => $request->input('heure_passage'),
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

        //         $heure_passage = $passage['jour'];
        //         $reserv_dayName = $passage['heure'];
        //         $empolyees_dispo = $empolyees_dispo->reject(function ($value, $key) use ($date_debut, $reserv_dayName, $heure_passage) {

        //             foreach ($value->reservations as $reserv) {
        //                 // vérifie si dispo  par rapport avec les reservations unique  attribué  
        //                 $dayName = Carbon::parse($reserv->date_passage)->locale('fr')->dayName;
        //                 if ($date_debut <= $reserv->date_passage ) {
        //                     if ($dayName == $reserv_dayName && $reserv->heure_passage == $heure_passage) {
        //                         return true;
        //                     }
        //                 }
        //                 //  vérifie si dispo par rapport avec les abonnements attribué
        //                 if ($reserv->pack) {
        //                     if ($reserv->date_debut >= $date_debut) {

        //                         foreach ($reserv->abonnement->passages as $passage) {
        //                             if ($passage["day"] == $reserv_dayName && $passage["time"] == $heure_passage) {
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
        //     $heure_passage = $reserv->heure_passage;
        //     $dayName = Carbon::parse($date_passage)->locale('fr')->dayName;

        //     // list des Empolyee disponible pour cette réservation     
        //     $empolyees_dispo = $empolyees_dispo->reject(function ($value, $key) use ($date_passage, $heure_passage, $dayName) {

        //         // if($value->reservations()->exists()) { }
        //         foreach ($value->reservations as $reserv) {
        //             // vérifie si dispo par rapport avec les reservations unique  attribué   
        //             if ($reserv->date_passage == $date_passage && $reserv->heure_passage == $heure_passage) {
        //                 return true;
        //             }
        //             // vérifie si dispo  par rapport avec les abonnements attribué
        //             if ($reserv->abonnement) {
        //                 if ($reserv->abonnement->date_debut <= $date_passage && $reserv->abonnement->date_fin >= $date_passage) {

        //                     foreach ($reserv->abonnement->passages as $passage) {
        //                         if ($passage["day"] == $dayName && $passage["time"] == $heure_passage) {
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
                'heure_passage' => 'required_without:date_debut',
            ]);
            $reserv->update([
                'date_passage' => $request->input('date_passage'),
                'heure_passage' => $request->input('heure_passage'),
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
