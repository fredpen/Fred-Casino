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
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users', 'bail'],
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
            'password' => 'required',
            'email' => 'required|string|email|min:5'
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
