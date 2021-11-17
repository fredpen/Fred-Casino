<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\User;
use App\Rules\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'bail'],
            'phone_number' => ['required', 'unique:users', new PhoneNumber],
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

    // show a single user
    public function show(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();

        return $user ?
            ResponseHelper::sendSuccess($user) : ResponseHelper::notFound("Invalid user Id");
    }

    // show logged in user
    public function userDetails(Request $request)
    {
        return  ResponseHelper::sendSuccess($request->user());
    }

    // show all users
    public function all()
    {
        $users = User::query();

        return $users->count() ?
            ResponseHelper::sendSuccess($users->get()) : ResponseHelper::notFound("Query returns empty");
    }


    // update
    public function update(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        if (!$user) {
            return ResponseHelper::notFound("Invalid User Id");
        }

        $validatedData = $request->validate([
            'name' => ['bail', 'sometimes', 'string', 'max:255', 'bail'],
            'password' => ['bail', "sometimes", 'string', "min:6", "max:20"],
            'email' => ['bail', "sometimes", 'email:rfc,dns', Rule::unique('users')->ignore($user->id)],
            'phone_number' => ['bail', "sometimes", new PhoneNumber,  Rule::unique('users')->ignore($user->id)],
        ]);

        if ($request->password) {
            $validatedData['password'] = bcrypt($request->password);
        }

        if (count($validatedData) < 1) {
            return ResponseHelper::badRequest("There is nothing to update");
        }

        return $user->update($validatedData) ?
            ResponseHelper::sendSuccess([], "User updated") : ResponseHelper::serverError("Could not updated the user");
    }

    // delete
    public function delete(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        if (!$user) {
            return ResponseHelper::serverError("Invalid User Id");
        }

        return $user->delete() ?
            ResponseHelper::sendSuccess([], "User deleted") : ResponseHelper::serverError("Could not delete the user");
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
