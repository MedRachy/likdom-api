<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::all();
        $total_offers = $offers->count();

        return view("admin.Offers.index", ['offers' => $offers, 'total_offers' => $total_offers]);
    }

    public function create()
    {
        return view("admin.Offers.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'nbr_passages' => ['nullable', 'integer'],
            'start_price' => ['nullable', 'string'],
            'user_type' => ['required', 'string', 'max:255'],
        ]);

        Offer::create([
            'label' => $request->label,
            'name' => $request->name,
            'description' => $request->description,
            'nbr_passages' => $request->nbr_passages,
            'start_price' => $request->start_price,
            'user_type' => $request->user_type,

        ]);

        return redirect()->action([OfferController::class, 'index']);
    }

    public function edit($id)
    {
        $offer = Offer::find($id);

        if ($offer) {
            return view('admin.Offers.edit')->with('offer', $offer);
        } else {
            return view('admin.Offers.404');
        }
    }

    public function update(Request $request, $id)
    {
        $offer = Offer::find($id);
        // validation
        $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'nbr_passages' => ['nullable', 'integer'],
            'start_price' => ['nullable', 'string'],
            'user_type' => ['required', 'string', 'max:255'],
        ]);
        // update
        $offer->update([
            'label' => $request->label,
            'name' => $request->name,
            'description' => $request->description,
            'nbr_passages' => $request->nbr_passages,
            'start_price' => $request->start_price,
            'user_type' => $request->user_type,
        ]);

        return redirect()->action([OfferController::class, 'index']);
    }

    public function destroy($id)
    {
        $offer = Offer::find($id);
        $offer->delete();
        return redirect()->action([OfferController::class, 'index']);
    }
}
