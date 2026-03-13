<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;

class HomeController extends Controller
{
    public function index()
    {
        $featuredItems = MenuItem::query()
            ->active()
            ->orderBy('category')
            ->orderBy('name')
            ->limit(6)
            ->get();

        return view('home', compact('featuredItems'));
    }
}
