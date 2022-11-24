<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Contract;
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

        Contract::create([
            'user_id' => Auth::id(),
            'subscription_id' => $request->subscription_id,
            'manager_name' => $request->manager_name,
            'company_name' => $request->company_name,
            'adress' => $request->adress,
            'city' => $request->city,
            'rc_number' => $request->rc_number,
            'capital' => $request->capital,
        ]);
    }
}
