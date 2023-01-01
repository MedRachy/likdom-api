<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Contract;
// use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractsController extends Controller
{
    public function store(Request $request)
    {
        // validation 
        $request->validate([
            'manager_name' => 'required',
            'company_name' => 'required',
            'adress' => 'required',
            'city' => 'required',
            'rc_number' => 'required',
            'capital' => 'required'
        ]);

        $contract = Contract::create([
            'user_id' => Auth::id(),
            'subscription_id' => $request->subscription_id,
            'manager_name' => $request->manager_name,
            'company_name' => $request->company_name,
            'adress' => $request->adress,
            'city' => $request->city,
            'rc_number' => $request->rc_number,
            'capital' => $request->capital,
        ]);


        // view()->share('contract', $contract->toArray());
        // $pdf = Pdf::loadView('pdf.contract', $contract->toArray());
        // return $pdf->download('Likdom_contract.pdf');
        return  response()->json(['message' => 'success'], 200);
    }

    // public function get_pdf()
    // {
    //     // $data = $contract->toArray();
    //     $data = ['name' => 'the name', 'email' => 'the email'];
    //     view()->share('data', $data);
    //     $pdf = Pdf::loadView('pdf.contract', $data);
    //     return $pdf->download('Likdom_contract.pdf');
    // }
}
