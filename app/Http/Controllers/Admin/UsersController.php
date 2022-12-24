<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DataTables;

class UsersController extends Controller
{

    public function index()
    {
        $total_users = User::where('role', 'user')
            ->count();
        return view("Admin.Users.index")->with('total_users', $total_users);
    }

    public function admins()
    {
        // super admin will not be shown 
        $admins = User::where('role', 'admin')->get();
        $total_admins = $admins->count();

        return view("Admin.Users.admins", ['admins' => $admins, 'total_admins' => $total_admins]);
    }

    public function search(Request $request)
    {

        $users = User::where('role', 'user')->get();
        // filter by params
        if ($request->has('params')) {

            $ville = collect();

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

            // filter by ville
            if ($ville->isNotEmpty()) {
                $users = $users->filter(function ($value) use ($ville) {
                    return $ville->contains($value->ville);
                });
            }

            // filter by pro
            if ($query->has('pro')) {
                $pro = $query['pro'];
                if ($pro == '1') {
                    $users = $users->filter(function ($value) {
                        return $value->entreprises()->exists();
                    });
                } else if ($pro == '0') {
                    $users = $users->reject(function ($value) {
                        return $value->entreprises()->exists();
                    });
                }
            }
        }

        return datatables()->of($users)
            ->addColumn('action', function (User $user) {
                $actionBtn = '<a href="' . route("admin.users.show", $user->id) . '" target="_blank" class="edit btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>';
                return $actionBtn;
            })
            ->toJson();
    }

    public function create()
    {
        return view("Admin.Users.create");
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'adresse' => ['string', 'max:255'],
            'ville' => ['string', 'max:255'],
            'phone' => ['required', 'string', 'size:10', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request['name'],
            'adresse' => $request['adresse'],
            'phone' => $request['phone'],
            'ville' => $request['ville'],
            'role' => $request['role'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        return redirect()->action(
            [UsersController::class, 'show'],
            $user->id
        );
    }


    public function show($id)
    {
        $user = User::find($id);

        //TODO : point fidelité 
        if ($user) {
            return view("Admin.Users.show", ['user' => $user]);
        } else {
            return view("Admin.Users.404");
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->action([UsersController::class, 'admins']);
    }
}
