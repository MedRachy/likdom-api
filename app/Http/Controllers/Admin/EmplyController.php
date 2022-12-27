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

            $city = collect();
            $availability = collect();

            $query = $request->collect();
            // remove items coming with request datatable
            $query = $query->except(['params', 'draw', 'columns', 'order', 'length', 'search', 'start', '_']);

            // city
            if ($query->has('Rabat')) {
                $city->push('Rabat');
            }
            if ($query->has('Casablanca')) {
                $city->push('Casablanca');
            }
            if ($query->has('Mohammedia')) {
                $city->push('Mohammedia');
            }
            // availability
            if ($query->has('available')) {
                $availability->push('available');
            }
            if ($query->has('unavailable')) {
                $availability->push('unavailable');
            }

            // filter by city
            if ($city->isNotEmpty()) {
                $employees = $employees->filter(function ($value) use ($city) {
                    return $city->contains($value->city);
                });
            }

            // filter by availability
            if ($availability->isNotEmpty()) {
                $employees = $employees->filter(function ($value) use ($availability) {
                    return $availability->contains($value->availability);
                });
            }
            // only for subscriptions 
            // filter by start_date
            if ($query->has('date_passage')) {
                $date_passage = $query['date_passage'];
                $employees = $employees->filter(function ($value) use ($date_passage) {
                    if ($value->subscriptions()->exists()) {
                        foreach ($value->subscriptions as $reserv) {
                            if ($reserv->start_date == $date_passage) {
                                return true;
                            }
                        }
                    }
                });
            }
            // // filter by start_time
            if ($query->has('heure_passage')) {
                $heure_passage = $query['heure_passage'];
                $employees = $employees->filter(function ($value) use ($heure_passage) {
                    if ($value->subscriptions()->exists()) {
                        foreach ($value->subscriptions as $reserv) {
                            if ($reserv->start_time == $heure_passage) {
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
                        return $value->subscriptions()->exists();
                    });
                } else if ($reserv == '0') {
                    $employees = $employees->reject(function ($value) {
                        return $value->subscriptions()->exists();
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
        $request->validate([
            'last_name' => 'required|string',
            'first_name' => 'required|string',
            'phone' => 'required',
            'adress' => 'required|string',
            'city' => 'required|string',
            'date_birth' => 'required|date',
            'sex' => 'required|string',
            'speciality' => 'required|string',
            'image_path' => 'required|mimes:png,jpg,jpeg',
        ]);

        // image name
        $imageName = $request->last_name . '-' . time() . '.' . $request->image_path->extension();
        // store in storage/app/public/Emplys ----> access from public after creating a storage:link
        $request->image_path->storeAs('Emplys', $imageName, 'public');

        $employee = Employee::create([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'phone' => $request->phone,
            'adress' => $request->adress,
            'city' => $request->city,
            'date_birth' => $request->date_birth,
            'sex' => $request->sex,
            'speciality' => $request->speciality,
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

            if ($employee->subscriptions()->exists()) {
                foreach ($employee->subscriptions as $reserv) {
                    if ($reserv->just_once) {
                        $event = [
                            'title' => 'Reserv-' . $reserv->id,
                            'description' => 'valider',
                            'url' => route('admin.reserv.show', $reserv->id),
                            'start' => $reserv->start_date,
                        ];
                        $events->push($event);
                    } elseif (!$reserv->just_once) {
                        // Periode from : date_debut until date_debut + month  
                        $start_date = Carbon::create($reserv->start_date);
                        $period = Carbon::parse($start_date)->daysUntil($start_date->addMonth());
                        $dates = $period->toArray();
                        foreach ($reserv->passages as $passage) {

                            for ($i = 0; $i < $period->count(); $i++) {
                                // get the dayname of every date in the periode 
                                $dayName = Carbon::parse($dates[$i])->locale('fr')->dayName;
                                $dayName = Str::ucfirst($dayName);
                                if ($passage['day'] == $dayName) {
                                    $event = [
                                        'title' => 'Reserv-abonmt-' . $reserv->id,
                                        'description' => 'valider',
                                        'color' => '#0d6efd',
                                        'url' => route('admin.abonmt.show', $reserv->id),
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
            if ($employee->subscriptionHistory()->exists()) {
                foreach ($employee->subscriptionHistory as $reserv) {
                    if ($reserv->just_once) {
                        $event = [
                            'title' => 'Reserv-' . $reserv->id,
                            'description' => 'terminer',
                            'color' => 'grey',
                            'url' => route('admin.reserv.show', $reserv->id),
                            'start' => $reserv->start_date,
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
            'city' => 'required|string',
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
            'city' => $request->input('city'),
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
        $subscriptions = $employee->reservHistory;
        // filter by params
        if ($request->has('params')) {

            $statut = collect();
            $city = collect();
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
            // city
            if ($query->has('Rabat')) {
                $city->push('Rabat');
            }
            if ($query->has('Casablanca')) {
                $city->push('Casablanca');
            }
            if ($query->has('Mohammedia')) {
                $city->push('Mohammedia');
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
                $subscriptions = $subscriptions->filter(function ($value) use ($statut) {
                    return $statut->contains($value->statut);
                });
            }
            // filter by city
            if ($city->isNotEmpty()) {
                $subscriptions = $subscriptions->filter(function ($value) use ($city) {
                    return $city->contains($value->city);
                });
            }
            // filter by service
            if ($service->isNotEmpty()) {
                $subscriptions = $subscriptions->filter(function ($value) use ($service) {
                    return $service->contains($value->service);
                });
            }
            // filter by type_logement
            if ($type_logement->isNotEmpty()) {
                $subscriptions = $subscriptions->filter(function ($value) use ($type_logement) {
                    return $type_logement->contains($value->type_logement);
                });
            }
            // filter by prix_min
            if ($query->has('prix_min')) {
                $prix_min = $query['prix_min'];
                $subscriptions = $subscriptions->filter(function ($value) use ($prix_min) {
                    return $value->prix >= $prix_min;
                });
            }
            // filter by prix_max
            if ($query->has('prix_max')) {
                $prix_max = $query['prix_max'];
                $subscriptions = $subscriptions->filter(function ($value) use ($prix_max) {
                    return $value->prix <= $prix_max;
                });
            }
            // filter by date_passage
            if ($query->has('date_passage')) {
                $date_passage = $query['date_passage'];
                $subscriptions = $subscriptions->filter(function ($value) use ($date_passage) {
                    return $value->date_passage == $date_passage;
                });
            }
            // filter by heure_passage
            if ($query->has('heure_passage')) {
                $heure_passage = $query['heure_passage'];
                $subscriptions = $subscriptions->filter(function ($value) use ($heure_passage) {
                    return $value->heure_passage == $heure_passage;
                });
            }
            // filter by date_debut
            if ($query->has('date_debut')) {
                $date_debut = $query['date_debut'];
                $subscriptions = $subscriptions->filter(function ($value) use ($date_debut) {
                    return $value->date_passage >=  $date_debut;
                });
            }
            // filter by date_fin
            if ($query->has('date_fin')) {
                $date_fin = $query['date_fin'];
                $subscriptions = $subscriptions->filter(function ($value) use ($date_fin) {
                    return $value->date_passage <=  $date_fin;
                });
            }
        }

        return datatables()->of($subscriptions)
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
            $employee->subscriptions()->detach();
            $employee->reservHistory()->detach();
            $employee->delete();
        }

        return redirect()->action([EmplyController::class, 'index']);
    }
}
