<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfferRessource;
use App\Models\Offer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class OffersController extends Controller
{
    public function pro_offers()
    {
        $offers = Cache::remember('pro_offers', Carbon::now()->addDays(3), function () {
            return Offer::where('user_type', 'pro')->get();
        });
        return OfferRessource::collection($offers);
    }
    public function part_offers()
    {
        $offers = Cache::remember('part_offers', Carbon::now()->addDays(3), function () {
            return Offer::where('user_type', 'part')->get();
        });
        return OfferRessource::collection($offers);
    }
}
