<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ContraController extends Controller
{
    public function index()
    {
        return view('Admin.Contracts.index');
    }

    public function search(Request $request)
    {

        $contracts = Contract::all();

        return datatables()->of($contracts)
            // ->addColumn('users', function (Contract $contract) {
            //     // $Link = '<a href="' . route("admin.users.show", $contract->user_id) . '"target="_blank"></a>';
            //     // return $Link;
            //     return '<a href="' . route("admin.users.show", $contract->user_id) . '></a>';
            // })
            ->addColumn('action', function (Contract $contract) {
                $actionBtn = '<a href="' . route("admin.contracts.show", $contract->id) . '" target="_blank" class="edit btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                <a href="' . route("admin.contracts.edit", $contract->id) . '" class="delete btn btn-secondary btn-sm"><i class="fas fa-edit"></i></a>';
                return $actionBtn;
            })
            ->toJson();
    }

    public function create()
    {
        return view("Admin.Contracts.create");
    }

    public function store(Request $request)
    {
        // validation 
        $request->validate([
            'manager_name' => 'required',
            'company_name' => 'required',
            'adress' => 'required',
            'city' => 'required',
            'rc_number' => 'required',
            'capital' => 'required',
            'cin_number' => 'required'
        ]);

        $contract = Contract::create([
            'user_id' => $request->user_id,
            'subscription_id' => $request->subscription_id,
            'manager_name' => $request->manager_name,
            'company_name' => $request->company_name,
            'adress' => $request->adress,
            'city' => $request->city,
            'rc_number' => $request->rc_number,
            'capital' => $request->capital,
            'cin_number' => $request->cin_number,
        ]);

        return redirect()->action(
            [ContraController::class, 'show'],
            $contract->id
        );
    }

    public function show($id)
    {
        $contract = Contract::find($id);

        if ($contract) {
            return view("Admin.Contracts.show", ['contract' => $contract]);
        } else {
            return view("Admin.Contracts.404");
        }
    }

    public function edit($id)
    {
        $contract = Contract::find($id);

        if ($contract) {
            return view('Admin.Contracts.edit')->with('contract', $contract);
        } else {
            return view('Admin.Contracts.404');
        }
    }

    public function update(Request $request, $id)
    {
        $contract = Contract::find($id);
        // validation 
        $request->validate([
            'manager_name' => 'required',
            'company_name' => 'required',
            'adress' => 'required',
            'city' => 'required',
            'rc_number' => 'required',
            'capital' => 'required',
            // 'cin_number' => 'required'
        ]);

        $contract->update([
            'user_id' => $request->user_id,
            'subscription_id' => $request->subscription_id,
            'manager_name' => $request->manager_name,
            'company_name' => $request->company_name,
            'adress' => $request->adress,
            'city' => $request->city,
            'rc_number' => $request->rc_number,
            'capital' => $request->capital,
            // 'cin_number' => $request->cin_number,
        ]);

        return redirect()->action(
            [ContraController::class, 'show'],
            $contract->id
        );
    }

    public function generate_pdf(Request $request)
    {
        $contract = Contract::find($request->contract_id);
        $company_name = $contract->company_name;
        // TODO : 
        // get all data needed for the contract : user info , sub info ... 
        $contract = $contract->toArray();

        view()->share('contract', $contract);
        $pdf = Pdf::loadView('pdf.contract', $contract);
        return $pdf->stream('Likdom_' . $company_name . '_contract.pdf');
    }
}
