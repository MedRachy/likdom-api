<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Str;


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
        // validation
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

        // generate image name 
        $imageName = $request->last_name . '-' . time() . '.' . $request->image_path->extension();
        // store in storage/app/public/Emplys ----> access from public after creating a storage:link
        $request->image_path->storeAs('Emplys', $imageName, 'public');

        // create
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
                        // Periode from : start_date until end_date  
                        $period = Carbon::parse($reserv->start_date)->daysUntil($reserv->end_date);
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
                    } elseif (!$reserv->just_once) {

                        // Periode from : start_date until end_date
                        $period = Carbon::parse($reserv->start_date)->daysUntil($reserv->end_date);
                        $dates = $period->toArray();
                        foreach ($reserv->passages as $passage) {

                            for ($i = 0; $i < $period->count(); $i++) {
                                // get the dayname of every date in the periode 
                                $dayName = Carbon::parse($dates[$i])->locale('fr')->dayName;
                                $dayName = Str::ucfirst($dayName);
                                if ($passage['day'] == $dayName) {
                                    $event = [
                                        'title' => 'Reserv-abonmt-' . $reserv->id,
                                        'description' => 'terminer',
                                        'color' => 'grey',
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
            'last_name' => 'required|string',
            'first_name' => 'required|string',
            'phone' => 'required',
            'adress' => 'required|string',
            'city' => 'required|string',
            'date_birth' => 'required|date',
            'sex' => 'required|string',
            'speciality' => 'required|string',
        ]);
        // update
        $employee->update([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'phone' => $request->phone,
            'adress' => $request->adress,
            'city' => $request->city,
            'date_birth' => $request->date_birth,
            'sex' => $request->sex,
            'speciality' => $request->speciality,
        ]);

        if ($request->has('image_path')) {
            // generate new image name
            $imageName = $request->last_name . '-' . time() . '.' . $request->image_path->extension();
            $request->image_path->storeAs('Emplys', $imageName, 'public');
            // update image_path
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
        $reservations = $employee->subscriptionHistory;
        // filter by just_once 
        $reservations = $reservations->filter(function ($value) {
            return $value->just_once;
        });
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

    public function history_sub($id)
    {
        return view("Admin.Emply.history_sub")->with('emplyID', $id);
    }

    public function subsearch(Request $request, $id)
    {
        $employee = Employee::find($id);
        $subscriptions = $employee->subscriptionHistory;
        // filter by just_once 
        $subscriptions = $subscriptions->filter(function ($value) {
            return !$value->just_once;
        });

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
                return $subscription->offer->name;
            })
            ->toJson();
    }

    public function destroy($id)
    {
        $employee = Employee::find($id);
        if ($employee) {
            $employee->subscriptions()->detach();
            $employee->subscriptionHistory()->detach();
            $employee->delete();
        }
        // TODO : 
        // delete images from storage 
        return redirect()->action([EmplyController::class, 'index']);
    }
}
