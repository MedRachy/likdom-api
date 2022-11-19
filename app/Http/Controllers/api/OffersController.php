<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfferRessource;
use App\Models\Offer;
use Illuminate\Http\Request;

class OffersController extends Controller
{
    public function pro_offers()
    {
        $offers = Offer::where('user_type', 'pro')->get();
        return OfferRessource::collection($offers);
    }
    public function part_offers()
    {
        $offers = Offer::where('user_type', 'part')->get();
        return OfferRessource::collection($offers);
    }
}
