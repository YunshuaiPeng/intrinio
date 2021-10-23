<?php

namespace App\Http\Controllers;

use App\Models\Security;

class HomeController extends Controller
{
    public function __invoke()
    {
        $securities = Security::query()
            ->withCount('historicalData')
            ->get();

        return view('home', [
            'securities' => $securities,
        ]);
    }
}
