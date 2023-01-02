<?php

namespace App\Http\Controllers\Admin;

use App\Events\ReservationCreated;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Subscription;

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
        // validation 
        $request->validate([
            'start_date' => 'required|date',
            'start_time' => 'required',
            'nbr_hours' => 'required',
            'nbr_employees' => 'required',
            'city' => 'required',
            'adress' => 'required'
        ]);

        $reservation = Subscription::create([
            'user_id' =>  $request->user_id,
            'service' => 'menage',
            'start_date' => $request->start_date,
            'start_time' => $request->start_time,
            'nbr_hours' => $request->nbr_hours,
            'nbr_employees' => $request->nbr_employees,
            'city' => $request->city,
            'adress' => $request->adress,
            'just_once' => true,
            'confirmed' => $request->confirmed,
        ]);

        // update prix 
        // $reservation->update([
        //     'prix' => $reservation->getPrix()
        // ]);

        // for testing
        event(new ReservationCreated($reservation->id, 'reserv'));

        return redirect()->action(
            [ReservController::class, 'show'],
            $reservation->id
        );
    }

    public function show($id)
    {
        $reserv = Subscription::find($id);
        if ($reserv) {
            return view('Admin.Reserv.show')->with('reserv', $reserv);
        } else {
            return view('Admin.Reserv.404');
        }
    }

    public function edit($id)
    {
        $reserv = Subscription::find($id);
        $empolyees_dispo = Employee::where('city', $reserv->city)
            ->where('availability', 'available')->get();

        return view('Admin.Reserv.edit', [
            'reserv' => $reserv,
            'employees' => $empolyees_dispo
        ]);
    }

    public function update(Request $request, $id)
    {
        $reserv = Subscription::find($id);
        // edit date & time passage
        if ($request->has('edit_passage')) {

            $request->validate([
                'start_date' => 'required|date',
                'start_time' => 'required',
            ]);
            $reserv->update([
                'start_date' => $request->start_date,
                'start_time' => $request->start_time,
            ]);
        }
        // update status
        if ($request->has('edit_status') && $request->filled('status')) {

            if ($request->input('status') == 'concluded') {
                // add to table enregistrements 
                foreach ($reserv->employees as $emply) {
                    $reserv->emplyHistory()->attach($emply->id);
                }
                // remove employee from reservation_employee
                $reserv->employees()->detach();
            }

            if ($request->input('status') == 'cancel') {
                $reserv->employees()->detach();
            }
            $reserv->update(['status' => $request->status]);
        }
        // add or remove emloyees for a reservation
        if ($request->has('edit_Emp_selected')) {

            if (!empty($request->input('Emp_selected'))) {
                // attach to employees_reservations
                $reserv->employees()->sync($request->Emp_selected);
                $reserv->update(['status' => 'valid']);
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
        $reserv = Subscription::find($id);
        // remove employee from reservation_employee
        $reserv->employees()->detach();
        $reserv->delete();
        return redirect()->action([ReservController::class, 'index']);
    }
}
