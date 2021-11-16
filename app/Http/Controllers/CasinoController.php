<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Casino;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class CasinoController extends Controller
{

    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:casinos', 'string', 'max:255', 'bail'],
            'logo' => ['required', 'mimes:jpg,jpeg,png', 'dimensions:width=180,height=90'],
            'bonus_information' => ['required', 'string'],
            'affiliate_link' => ['required', 'string', 'min:8'],
        ]);
        $input = $request->only(['name', 'bonus_information', 'affiliate_link']);

        if ($request->file('logo')) {
            $path =  $request->file('logo')->storePublicly('public/casino/logos');
            $baseUrl = Config::get('app.url');
            $input['logo_url'] = $baseUrl . Storage::url($path);
        }

        $casino = Casino::create($input);
        return $casino ?
            ResponseHelper::sendSuccess($casino) : ResponseHelper::notFound("Casino creation failed");
    }

    // show a single casino
    public function show(Request $request)
    {
        $casino = Casino::query()
            ->where('id', $request->casino_id_or_name)
            ->orWhere('name', $request->casino_id_or_name)
            ->first();

        return $casino ?
            ResponseHelper::sendSuccess($casino) : ResponseHelper::notFound("Invalid casino Id or name");
    }

    // show all casinos
    public function all()
    {
        $casinos = Casino::query();

        return $casinos->count() ?
            ResponseHelper::sendSuccess($casinos->get()) : ResponseHelper::notFound("Query returns empty");
    }


    // update
    public function update(Request $request)
    {

        $casino = Casino::where('id', $request->casino_id)->first();
        if (!$casino) {
            return ResponseHelper::notFound("Invalid Casino Id");
        }

        $validatedData = $request->validate([
            'name' => ['sometimes', 'string', 'max:255', 'bail'],
            'email' => $request->email != $casino->email ? ["sometimes", 'email:rfc,dns', 'unique:casinos'] : ["nullable"],
            'phone_number' => $request->phone_number != $casino->phone_number ? ["sometimes", new PhoneNumber] : ["nullable"],
            'password' => ["sometimes", 'string', "min:6", "max:20"],
        ]);

        if ($request->password) {
            $validatedData['password'] = bcrypt($request->password);
        }

        return $casino->update($validatedData) ?
            ResponseHelper::sendSuccess([], "Casino updated") : ResponseHelper::serverError("Could not updated the casino");
    }

    // delete
    public function delete(Request $request)
    {
        $casino = Casino::where('id', $request->casino_id)->first();
        if (!$casino) {
            return ResponseHelper::serverError("Invalid Casino Id");
        }

        return $casino->delete() ?
            ResponseHelper::sendSuccess([], "Casino deleted") : ResponseHelper::serverError("Could not delete the casino");
    }
}
