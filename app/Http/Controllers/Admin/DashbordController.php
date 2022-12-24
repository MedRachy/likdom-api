<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Models\Candidature;
// use App\Models\Devi;
use Illuminate\Http\Request;
// use App\Models\Reservation;
// use App\Models\User;
use Carbon\Carbon;

class DashbordController extends Controller
{
    public function index()
    {
        return view("admin.index");
        // today date and name
        // $today = Carbon::today()->format('Y-m-d');
        // $todayName = ucfirst(Carbon::parse($today)->locale('fr')->dayName);

        // // list des reserv en attente de validation
        // $reservations = Reservation::where('statut', "en_attente")
        //     ->where('type_passage', 'unique')
        //     ->orderBy('date_passage')
        //     ->get();

        // // list des reserv de la journée 
        // $today_reservations = Reservation::where('date_passage', $today)
        //     ->orderBy('heure_passage')
        //     ->get();

        // // list des abonnement en attente 
        // $abonnements = Reservation::where('statut', "en_attente")
        //     ->where('type_passage', 'abonnement')
        //     ->orderBy('date_debut')
        //     ->get();

        // // list des abonnement active de la journée 
        // $today_abonnements = Reservation::where('date_debut', '<=', $today)
        //     ->get();
        // // filtrer par dayname
        // $today_abonnements = $today_abonnements->filter(function ($value) use ($todayName) {
        //     foreach ($value->passages as $passage) {
        //         if ($passage["jour"] == $todayName) {
        //             return true;
        //         }
        //     }
        // });
        // // count 
        // $total_users = User::where('role', 'user')
        //     ->count();
        // $reservs_en_attent = $reservations->count();
        // $reservs_today = $today_reservations->count();
        // $abonmts_today = $today_abonnements->count();

        // // count employee reserv unique    
        // $employees_reservs = $today_reservations->map(function ($item) {
        //     if ($item->employees) {
        //         return $item->employees->count();
        //     }
        // });

        // // count employee abonmt
        // $employees_abonmts = $today_abonnements->map(function ($item) {
        //     if ($item->employees) {
        //         return $item->employees->count();
        //     }
        // });
        // $employees_abonmts = $employees_abonmts->sum();
        // $employees_reservs = $employees_reservs->sum();
        // $employees_today = $employees_reservs + $employees_abonmts;

        // return view("admin.index", [
        //     'reservations' => $reservations,
        //     'abonnements' => $abonnements,
        //     'today_reservations' => $today_reservations,
        //     'today_abonnements' => $today_abonnements,
        //     'today' => $today,
        //     'todayName' => $todayName,
        //     'reservs_en_attent' => $reservs_en_attent,
        //     'reservs_today' => $reservs_today,
        //     'abonmts_today' => $abonmts_today,
        //     'employees_today' => $employees_today,
        //     'total_users' => $total_users
        // ]);
    }

    // public function charts()
    // {
    //     return view("Admin.charts");
    // }

    // public function dataSearch(Request $request)
    // {

    //     $dataService = collect();
    //     $dataReserv = collect();
    //     $yearstart = "2022-01-01";
    //     $dataUsers = collect([
    //         'janvier' => 0, 'février' => 0, 'mars' => 0, 'avril' => 0,
    //         'mai' => 0, 'juin' => 0, 'juillet' => 0, 'août' => 0, 'septembre' => 0,
    //         'octobre' => 0, 'novembre' => 0, 'décembre' => 0
    //     ]);
    //     $dataReservYear = collect([
    //         'janvier' => 0, 'février' => 0, 'mars' => 0, 'avril' => 0,
    //         'mai' => 0, 'juin' => 0, 'juillet' => 0, 'août' => 0, 'septembre' => 0,
    //         'octobre' => 0, 'novembre' => 0, 'décembre' => 0
    //     ]);


    //     $reservations = Reservation::orderBy('date_passage')->get();
    //     $reservs = Reservation::all();
    //     $users = User::where('role', 'user')->get();

    //     if ($request->has('year')) {
    //         $yearstart = $request['year'];
    //     }
    //     $yearend = Carbon::parse($yearstart)->lastOfYear()->format('Y-m-d');

    //     //  users / months of a year   
    //     $users = $users->filter(function ($value) use ($yearstart, $yearend) {
    //         if ($value->created_at >= $yearstart && $value->created_at <= $yearend) {
    //             return true;
    //         }
    //     });
    //     $users = $users->map(function ($value) use ($dataUsers) {
    //         $month = Carbon::parse($value->created_at)->locale('fr')->monthName;
    //         $dataUsers[$month] = $dataUsers[$month] + 1;
    //     });

    //     // Reserv / months of a year
    //     $reservs = $reservs->filter(function ($value) use ($yearstart, $yearend) {
    //         if ($value->created_at >= $yearstart && $value->created_at <= $yearend) {
    //             return true;
    //         }
    //     });
    //     $reservs = $reservs->map(function ($value) use ($dataReservYear) {
    //         $month = Carbon::parse($value->created_at)->locale('fr')->monthName;
    //         $dataReservYear[$month] = $dataReservYear[$month] + 1;
    //     });

    //     // filter by date_debut
    //     if ($request->has('date_debut')) {
    //         $date_debut = $request['date_debut'];
    //         $reservations = $reservations->filter(function ($value) use ($date_debut) {
    //             return $value->date_passage >=  $date_debut;
    //         });
    //     } else {
    //         // NOTE : start of the month may be not good idea
    //         // $date_debut =  Carbon::now()->startOfMonth()->format('Y-m-d'); 
    //         // last month
    //         $date_debut = Carbon::now()->subMonth()->format('Y-m-d');
    //         $reservations = $reservations->filter(function ($value) use ($date_debut) {
    //             return $value->date_passage >=  $date_debut;
    //         });
    //     }
    //     // filter by date_fin
    //     if ($request->has('date_fin')) {
    //         $date_fin = $request['date_fin'];
    //         $reservations = $reservations->filter(function ($value) use ($date_fin) {
    //             return $value->date_passage <=  $date_fin;
    //         });
    //     }
    //     // nbr reserv / jour 
    //     $reservByday = $reservations->groupBy('date_passage');
    //     $reservByday->map(function ($item, $key) use ($dataReserv) {
    //         $date = Carbon::parse($key)->format('d/m/y');
    //         $dataReserv[$date] = $item->count();
    //     });
    //     // nbr reserv / service 
    //     $reservByservice = $reservations->groupBy('service');
    //     $reservByservice->map(function ($item, $key) use ($dataService) {
    //         $dataService[$key] = $item->count();
    //     });

    //     $data = [
    //         'dataService' => $dataService,
    //         'dataReserv' => $dataReserv,
    //         'dataReservYear' => $dataReservYear,
    //         'dataUsers' => $dataUsers,
    //     ];

    //     return $data;
    // }

    // public function devis()
    // {
    //     return view("admin.devis");
    // }

    // public function devisearch(Request $request)
    // {
    //     $devis = Devi::all();

    //     // filter by params
    //     if ($request->has('params')) {

    //         $statut = collect();
    //         $services = collect();

    //         $query = $request->collect();
    //         // remove items coming with request datatable
    //         $query = $query->except(['params', 'draw', 'columns', 'order', 'length', 'search', 'start', '_']);
    //         // statut
    //         if ($query->has('en_attente')) {
    //             $statut->push('en_attente');
    //         }
    //         if ($query->has('valider')) {
    //             $statut->push('valider');
    //         }
    //         if ($query->has('annuler')) {
    //             $statut->push('annuler');
    //         }
    //         if ($query->has('terminer')) {
    //             $statut->push('terminer');
    //         }
    //         // service 
    //         if ($query->has('nett_pro')) {
    //             $services->push('nett_pro');
    //         }
    //         if ($query->has('nett_sec')) {
    //             $services->push('nett_sec');
    //         }
    //         if ($query->has('nett_vitre')) {
    //             $services->push('nett_vitre');
    //         }
    //         if ($query->has('cristalisation')) {
    //             $services->push('cristalisation');
    //         }
    //         if ($query->has('desinfection')) {
    //             $services->push('desinfection');
    //         }
    //         if ($query->has('jardinage')) {
    //             $services->push('jardinage');
    //         }

    //         //  filter by statut 
    //         if ($statut->isNotEmpty()) {
    //             $devis =   $devis->filter(function ($value) use ($statut) {
    //                 return $statut->contains($value->statut);
    //             });
    //         }

    //         // filter by service
    //         if ($services->isNotEmpty()) {

    //             $devis = $devis->filter(function ($value) use ($services) {
    //                 if (!is_null($value->services)) {
    //                     $diff = $services->diff($value->services);
    //                     if ($diff->count() == 0) {
    //                         return true;
    //                     }
    //                 }
    //             });
    //         }

    //         // filter by prix_min
    //         if ($query->has('prix_min')) {
    //             $prix_min = $query['prix_min'];
    //             $devis = $devis->filter(function ($value) use ($prix_min) {
    //                 return $value->prix >= $prix_min;
    //             });
    //         }
    //         // filter by prix_max
    //         if ($query->has('prix_max')) {
    //             $prix_max = $query['prix_max'];
    //             $devis = $devis->filter(function ($value) use ($prix_max) {
    //                 return $value->prix <= $prix_max;
    //             });
    //         }
    //         // filter by produits
    //         if ($query->has('produits')) {
    //             $produits = $query['produits'];
    //             $devis = $devis->filter(function ($value) use ($produits) {
    //                 return $value->produits == $produits;
    //             });
    //         }
    //     }

    //     return datatables()->of($devis)->toJson();
    // }

    // public function candidatures()
    // {
    //     return view("Admin.candidatures");
    // }

    // public function candidatsearch(Request $request)
    // {
    //     $candidatures = Candidature::all();

    //     // filter by params
    //     if ($request->has('params')) {

    //         $statut = collect();
    //         $ville = collect();
    //         $specialite = collect();

    //         $query = $request->collect();
    //         // remove items coming with request datatable
    //         $query = $query->except(['params', 'draw', 'columns', 'order', 'length', 'search', 'start', '_']);
    //         // statut
    //         if ($query->has('en_attente')) {
    //             $statut->push('en_attente');
    //         }
    //         if ($query->has('valider')) {
    //             $statut->push('valider');
    //         }
    //         if ($query->has('annuler')) {
    //             $statut->push('annuler');
    //         }
    //         if ($query->has('terminer')) {
    //             $statut->push('terminer');
    //         }
    //         // ville
    //         if ($query->has('Rabat')) {
    //             $ville->push('Rabat');
    //         }
    //         if ($query->has('Casablanca')) {
    //             $ville->push('Casablanca');
    //         }
    //         if ($query->has('Mohammedia')) {
    //             $ville->push('Mohammedia');
    //         }
    //         // specialite
    //         if ($query->has('menage')) {
    //             $specialite->push('menage');
    //         }
    //         if ($query->has('cuisine')) {
    //             $specialite->push('cuisine');
    //         }
    //         if ($query->has('jardinage')) {
    //             $specialite->push('jardinage');
    //         }

    //         //  filter by statut 
    //         if ($statut->isNotEmpty()) {
    //             $candidatures = $candidatures->filter(function ($value) use ($statut) {
    //                 return $statut->contains($value->statut);
    //             });
    //         }
    //         // filter by ville
    //         if ($ville->isNotEmpty()) {
    //             $candidatures = $candidatures->filter(function ($value) use ($ville) {
    //                 return $ville->contains($value->ville);
    //             });
    //         }

    //         // filter by specialite
    //         if ($specialite->isNotEmpty()) {
    //             $candidatures = $candidatures->filter(function ($value) use ($specialite) {
    //                 return $specialite->contains($value->specialite);
    //             });
    //         }
    //     }

    //     return datatables()->of($candidatures)->toJson();
    // }
}
