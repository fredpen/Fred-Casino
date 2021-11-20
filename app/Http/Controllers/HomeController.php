<?php

namespace App\Http\Controllers;

use App\Models\Casino;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function users()
    {
        return Inertia::render('Users/Index', []);
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
