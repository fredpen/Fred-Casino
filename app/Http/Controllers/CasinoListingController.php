<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\CasinoListing;
use App\Models\Country;
use App\Rules\ListingRule;
use Illuminate\Http\Request;

class CasinoListingController extends Controller
{
    // update
    public function syncCountryListings(Request $request)
    {
        $request->validate([
            'country_id' => ["exists:countries,id"],
            'casinoIds' => ['bail', 'array', 'min:1', new ListingRule],
        ]);

        $country = Country::where('id', $request->country_id)->first();
        $casinoIds = collect($request->casinoIds);
        $requestObject = $casinoIds->mapWithKeys(fn ($item, $key) =>  [$item => ['level' => $key]]);
        $update = $country->casinos()->sync($requestObject);

        return $update ? ResponseHelper::sendSuccess([]) :   ResponseHelper::notFound("Query returns empty");
    }

    // show listing of a single country
    public function countryListings(Request $request)
    {
        $casinoListings = CasinoListing::where('country_id', $request->country_id);
        if (!$casinoListings->count()) {
            return ResponseHelper::notFound("Query returns empty");
        }

        $listings = $casinoListings->get();
        $casinos = $listings->map(fn ($item) =>  $item->only(['level', 'casino']));
        $groupedListings = ["casinos" => $casinos,   "country" => $listings[0]->country];

        return ResponseHelper::sendSuccess($groupedListings);
    }

    // show all listings
    public function all()
    {
        $casinoListings = CasinoListing::query();
        if (!$casinoListings->count()) {
            return ResponseHelper::notFound("Query returns empty");
        }

        $casinoListings = $casinoListings->get()->groupBy('country_id');
        foreach ($casinoListings as $listings) {
            $casinos = $listings->map(fn ($item) =>  $item->only(['level', 'casino']));
            $groupedListings[] = ["casinos" => $casinos,   "country" => $listings[0]->country];
        }

        return ResponseHelper::sendSuccess($groupedListings);
    }
}
