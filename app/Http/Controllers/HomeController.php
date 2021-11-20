<?php

namespace App\Http\Controllers;

use App\Models\Casino;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function users()
    {
        return Inertia::render('Users/Index', []);
    }

    public function index(Request $request)
    {
        if ($request->user()) {
            return redirect("/users");
        }

        return redirect('/login');
    }

    public function dashboard()
    {
        return Inertia::render('Dashboard', [
            "token" => Auth::user()->createToken('user')->plainTextToken
        ]);
    }

    public function listings()
    {
        return Inertia::render('Listings/Index', [
            "casinos" => Casino::all(['id', 'name'])
        ]);
    }

    public function casinos()
    {
        return Inertia::render('Casinos/Index', []);
    }
}
