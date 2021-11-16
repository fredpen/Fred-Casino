<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Casino;
use Illuminate\Http\Request;

class CasinoController extends Controller
{

    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'bail'],
            'password' => ['required', 'string', 'min:8', 'bail'],
            'email' => ['required', 'email:rfc,dns', 'max:255', 'unique:casinos', 'bail'],
        ]);

        $input = $request->only(['name', 'phone_number', 'email', 'password']);
        $input['password'] = bcrypt($input['password']);
        $casino = Casino::create($input);

        if (!$casino) {
            return ResponseHelper::serverError();
        }

        $token = $casino->createToken('casino');
        $success['token'] = $token->plainTextToken;
        $success['casino'] = $casino;

        return ResponseHelper::sendSuccess($success);
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
