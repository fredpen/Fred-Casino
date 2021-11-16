<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\User;
use App\Rules\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'bail'],
            'phone_number' => ['required', new PhoneNumber],
            'password' => ['required', 'string', 'min:8', 'bail'],
            'email' => ['required', 'email:rfc,dns', 'max:255', 'unique:users', 'bail'],
        ]);

        $input = $request->only(['name', 'phone_number', 'email', 'password']);
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        if (!$user) {
            return ResponseHelper::serverError();
        }

        $token = $user->createToken('user');
        $success['token'] = $token->plainTextToken;
        $success['user'] = $user;

        return ResponseHelper::sendSuccess($success);
    }

    //login
    public function login(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'bail'],
            'email' => ['required', 'email:rfc,dns', 'max:255', 'bail'],
        ]);

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return ResponseHelper::unAuthorised("Incorrect email and password combination");
        }

        $user = Auth::user();
        $token = $user->createToken('user')->plainTextToken;

        return ResponseHelper::sendSuccess(
            ['token' => $token, 'user' => $user],
            "logged in successfully"
        );
    }

    // update
    public function update(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        if (!$user) {
            return ResponseHelper::notFound("Invalid User Id");
        }

        $validatedData = $request->validate([
            'name' => ['sometimes', 'string', 'max:255', 'bail'],
            'email' => $request->email != $user->email ? ["sometimes", 'email:rfc,dns', 'unique:users'] : ["nullable"],
            'phone_number' => $request->phone_number != $user->phone_number ? ["sometimes", new PhoneNumber] : ["nullable"],
            'password' => ["sometimes", 'string', "min:6", "max:20"],
        ]);

        if ($request->password) {
            $validatedData['password'] = bcrypt($request->password);
        }
        $update = $user->update($validatedData);

        if (!$update) {
            return ResponseHelper::serverError("Could not update the user");
        }

        return ResponseHelper::sendSuccess([], "User updated");
    }


    //logout
    public function logout(Request $request)
    {
        $isUser = $request->user()->currentAccessToken()->delete();
        if (!$isUser) {
            return ResponseHelper::serverError();
        }

        return ResponseHelper::sendSuccess([], "Successfully logged out.");
    }
}
