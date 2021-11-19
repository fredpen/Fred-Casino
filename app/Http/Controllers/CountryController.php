<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Country;

class CountryController extends Controller
{
    // show all countries
    public function all()
    {
        $countries = Country::query();
        return $countries->count() ?
            ResponseHelper::sendSuccess($countries->get()) : ResponseHelper::notFound("Query returns empty");
    }
}
