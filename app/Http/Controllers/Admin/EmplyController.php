<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DataTables;


class EmplyController extends Controller
{

    public function index()
    {
        return view('Admin.Emply.index');
    }

    public function search(Request $request)
    {

        $employees = Employee::all();

        // filter by params
        if ($request->has('params')) {

            $ville = collect();
            $disponible = collect();

            $query = $request->collect();
            // remove items coming with request datatable
            $query = $query->except(['params', 'draw', 'columns', 'order', 'length', 'search', 'start', '_']);

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
            // disponible
            if ($query->has('disponible')) {
                $disponible->push('disponible');
            }
            if ($query->has('conge')) {
                $disponible->push('conge');
            }
            if ($query->has('autre')) {
                $disponible->push('autre');
            }

            // filter by ville
            if ($ville->isNotEmpty()) {
                $employees = $employees->filter(function ($value) use ($ville) {
                    return $ville->contains($value->ville);
                });
            }

            // filter by disponible
            if ($disponible->isNotEmpty()) {
                $employees = $employees->filter(function ($value) use ($disponible) {
                    return $disponible->contains($value->disponibilite);
                });
            }

            // filter by date_passage
            if ($query->has('date_passage')) {
                $date_passage = $query['date_passage'];
                $employees = $employees->filter(function ($value) use ($date_passage) {
                    if ($value->reservations()->exists()) {
                        foreach ($value->reservations as $reserv) {
                            if ($reserv->date_passage == $date_passage) {
                                return true;
                            }
                        }
                    }
                });
            }
            // // filter by heure_passage
            if ($query->has('heure_passage')) {
                $heure_passage = $query['heure_passage'];
                $employees = $employees->filter(function ($value) use ($heure_passage) {
                    if ($value->reservations()->exists()) {
                        foreach ($value->reservations as $reserv) {
                            if ($reserv->heure_passage == $heure_passage) {
                                return true;
                            }
                        }
                    }
                });
            }
            // filter by reserv
            if ($query->has('reserv')) {
                $reserv = $query['reserv'];
                if ($reserv == '1') {
                    $employees = $employees->filter(function ($value) {
                        return $value->reservations()->exists();
                    });
                } else if ($reserv == '0') {
                    $employees = $employees->reject(function ($value) {
                        return $value->reservations()->exists();
                    });
                }
            }
        }

        return datatables()->of($employees)
            ->addColumn('action', function (Employee $employee) {
                $actionBtn = '<a href="' . route("admin.emply.show", $employee->id) . '" target="_blank" class="edit btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                <a href="' . route("admin.emply.edit", $employee->id) . '" class="delete btn btn-secondary btn-sm"><i class="fas fa-edit"></i></a>';
                return $actionBtn;
            })
            ->toJson();
    }

    public function create()
    {
        return view("Admin.Emply.create");
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'adresse' => 'required|string',
            'ville' => 'required|string',
            'age' => 'required|integer',
            'sex' => 'required|string',
            'specialite' => 'required|string',
            'phone' => 'required',
            'image_path' => 'required|mimes:png,jpg,jpeg',

        ]);
        // image name
        $imageName = $request->nom . '-' . time() . '.' . $request->image_path->extension();
        // store in storage/app/public/Emplys ----> access from public after creating a storage:link
        $request->image_path->storeAs('Emplys', $imageName, 'public');

        $employee = Employee::create([

            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenom'),
            'adresse' => $request->input('adresse'),
            'ville' => $request->input('ville'),
            'age' => $request->input('age'),
            'sex' => $request->input('sex'),
            'specialite' => $request->input('specialite'),
            'phone' => $request->input('phone'),
            'image_path' => $imageName
        ]);

        return redirect()->action(
            [EmplyController::class, 'show'],
            $employee->id
        );
    }

    public function show($id)
    {
        $employee = Employee::find($id);
        $events = collect();

        if ($employee) {

            if ($employee->reservations()->exists()) {
                foreach ($employee->reservations as $reserv) {
                    if ($reserv->type_passage == "unique") {
                        $event = [
                            'title' => 'Reserv-' . $reserv->id,
                            'description' => 'valider',
                            'url' => route('admin.reserv.show', $reserv->id),
                            'start' => $reserv->date_passage,
                        ];
                        $events->push($event);
                    } elseif ($reserv->type_passage == "abonnement") {
                        // Periode from : date_debut until date_debut + month  
                        $date_debut = Carbon::create($reserv->date_debut);
                        $period = Carbon::parse($date_debut)->daysUntil($date_debut->addMonth());
                        $dates = $period->toArray();
                        foreach ($reserv->passages as $passage) {

                            for ($i = 0; $i < $period->count(); $i++) {
                                // get the dayname of every date in the periode 
                                $dayName = Carbon::parse($dates[$i])->locale('fr')->dayName;
                                $dayName = Str::ucfirst($dayName);
                                if ($passage['jour'] == $dayName) {
                                    $event = [
                                        'title' => 'Reserv-abonmt-' . $reserv->id,
                                        'description' => 'valider',
                                        'color' => '#0d6efd',
                                        'url' => route('admin.reserv.show', $reserv->id),
                                        'start' => $dates[$i]->format('Y-m-d'),
                                    ];
                                    $events->push($event);
                                }
                            }
                        }
                    }
                }
            }
            // old reserv 
            if ($employee->reservHistory()->exists()) {
                foreach ($employee->reservHistory as $reserv) {
                    if ($reserv->type_passage == "unique") {
                        $event = [
                            'title' => 'Reserv-' . $reserv->id,
                            'description' => 'terminer',
                            'color' => 'grey',
                            'url' => route('admin.reserv.show', $reserv->id),
                            'start' => $reserv->date_passage,
                        ];
                        $events->push($event);
                    }
                    // passage abonmt
                    // TODO : add date_fin to have the excate periode 

                }
            }

            return view('Admin.Emply.show')->with('employee', $employee)
                ->with('events', $events);
        } else {
            return view('Admin.Emply.404');
        }
    }

    public function edit($id)
    {
        $employee = Employee::find($id);

        if ($employee) {
            return view('Admin.Emply.edit')->with('employee', $employee);
        } else {
            return view('Admin.Emply.404');
        }
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);
        // validation
        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'adresse' => 'required|string',
            'ville' => 'required|string',
            'age' => 'required|integer',
            'sex' => 'required|string',
            'specialite' => 'required|string',
            'phone' => 'required',
            'image_path' => 'mimes:png,jpg,jpeg',
            'disponibilite' => 'required|string'
        ]);
        // update
        $employee->update([
            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenom'),
            'adresse' => $request->input('adresse'),
            'ville' => $request->input('ville'),
            'age' => $request->input('age'),
            'sex' => $request->input('sex'),
            'specialite' => $request->input('specialite'),
            'phone' => $request->input('phone'),
            'disponibilite' => $request->input('disponibilite'),
        ]);
        if ($request->has('image_path')) {

            // image name
            $imageName = $request->nom . '-' . time() . '.' . $request->image_path->extension();
            // store in storage/app/public/Emplys ----> access from public after creating a storage:link
            $request->image_path->storeAs('Emplys', $imageName, 'public');

            $employee->update(['image_path' => $imageName]);
        }
        return redirect()->action(
            [EmplyController::class, 'show'],
            $employee->id
        );
    }

    public function history($id)
    {
        return view("Admin.Emply.history")->with('emplyID', $id);
    }

    public function reservsearch(Request $request, $id)
    {
        $employee = Employee::find($id);
        $reservations = $employee->reservHistory;
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
            if ($query->has('pack_etudiant')) {
                $service->push('pack_etudiant');
            }
            if ($query->has('menage_pro')) {
                $service->push('menage_pro');
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
            ->addColumn('pack', function (Reservation $reservation) {
                if ($reservation->pack) {
                    return  $reservation->pack->name;
                }
                return "";
            })
            ->toJson();
    }

    public function destroy($id)
    {
        $employee = Employee::find($id);
        if ($employee) {
            $employee->reservations()->detach();
            $employee->reservHistory()->detach();
            $employee->delete();
        }

        return redirect()->action([EmplyController::class, 'index']);
    }
}
