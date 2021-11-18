<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Casino;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CasinoController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'bonus_information' => ['bail', 'required', 'string'],
            'affiliate_link' => ['bail', 'required', 'url', 'min:8'],
            'name' => ['bail', 'required', 'unique:casinos', 'string', 'max:255'],
            'logo' => ['bail', 'required', 'mimes:jpg,jpeg,png', 'dimensions:width=180,height=90'],
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

    // update
    public function update(Request $request)
    {
        $casino = Casino::where('id', $request->casino_id)->first();
        if (!$casino) {
            return ResponseHelper::notFound("Invalid casino Id");
        }

        $request->validate([
            'bonus_information' => ['bail', 'sometimes', 'string'],
            'affiliate_link' => ['bail', 'sometimes', 'url', 'min:8'],
            'logo' => ['bail', 'sometimes', 'mimes:jpg,jpeg,png', 'dimensions:width=180,height=90'],
            'name' => ['bail', 'sometimes',  Rule::unique('casinos')->ignore($casino->id), 'string', 'max:255'],
        ]);

        $validatedData = $request->only(['name', 'bonus_information', 'affiliate_link']);

        if ($request->file('logo')) {
            $casino->removeExistingLogo();
            $newLogo = $casino->storeNewLogo($request->file('logo'));
            $validatedData['logo_url'] = $newLogo;
        }

        return $casino->update($validatedData) ?
            ResponseHelper::sendSuccess($casino) : ResponseHelper::serverError("Could not update casion at this time");
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
        if (!$casinos->count()) {
            return  ResponseHelper::notFound("Query returns empty");
        }

        return ResponseHelper::sendSuccess($casinos->orderBy('created_at', 'desc')->get());
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
