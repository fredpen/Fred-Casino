<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class HomeController extends Controller
{
    public function users()
    {
        return Inertia::render('Users/Index', []);
    }

    public function listings()
    {
        return Inertia::render('Listings/Index', []);
    }

    public function casinos()
    {
        return Inertia::render('Casinos/Index', []);
    }
}
