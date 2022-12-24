<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Carbon\Carbon;
use DataTables;

class AbonmtController extends Controller
{

    public function index()
    {
        return view('Admin.Abonmt.index');
    }

    public function search(Request $request)
    {

        $reservations = Reservation::where('type_passage', 'abonnement')->get();

        // filter by params
        if ($request->has('params')) {

            $statut = collect();
            $ville = collect();
            $pack = collect();
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
            if ($query->has('Mohammedia')) {
                $ville->push('Mohammedia');
            }
            if ($query->has('Casablanca')) {
                $ville->push('Casablanca');
            }
            // pack 
            if ($query->has('Likyoum')) {
                $pack->push('Likyoum');
            }
            if ($query->has('Likmeta')) {
                $pack->push('Likmeta');
            }
            if ($query->has('Likdima')) {
                $pack->push('Likdima');
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
            if ($pack->isNotEmpty()) {
                $reservations = $reservations->filter(function ($value) use ($pack) {
                    return $pack->contains($value->pack->name);
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

            // filter by date_debut
            if ($query->has('date_debut')) {
                $date_debut = $query['date_debut'];
                $reservations = $reservations->filter(function ($value) use ($date_debut) {
                    return $value->date_debut >=  $date_debut;
                });
            }
            // filter by date_fin
            if ($query->has('date_fin')) {
                $date_fin = $query['date_fin'];
                $reservations = $reservations->filter(function ($value) use ($date_fin) {
                    return $value->date_debut <=  $date_fin;
                });
            }
        }

        return datatables()->of($reservations)
            ->addColumn('action', function (Reservation $reservation) {
                $actionBtn = '<a href="' . route("admin.reserv.show", $reservation->id) . '" target="_blank" class="edit btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                <a href="' . route("admin.reserv.edit", $reservation->id) . '" class="delete btn btn-secondary btn-sm"><i class="fas fa-edit"></i></a>';
                return $actionBtn;
            })
            ->addColumn('pack', function (Reservation $reservation) {
                return $reservation->pack->name;
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
            'pack_id' => $request->input('pack_id'),
            'type_passage' => 'abonnement',
            'date_debut' => $request->input('date_debut'),
            'passages' => $passages,
            'type_logement' => $request->input('type_logement'),
            'pieces' => $pieces,
            'ville' => $request->input('ville'),
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
